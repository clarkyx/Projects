/***********************************************************
     Starter code for Assignment 3

     This code was originally written by Jack Wang for
		    CSC418, SPRING 2005

		Implementations of functions in raytracer.h, 
		and the main function which specifies the 
		scene to be rendered.	

***********************************************************/

#include "raytracer.h"
#include "bmp_io.h"
#include "util.h"
#include <cmath>
#include <iostream>
#include <cstdlib>

Raytracer::Raytracer() : _lightSource(NULL) {
	_root = new SceneDagNode();
}

Raytracer::~Raytracer() {
	delete _root;
}

SceneDagNode* Raytracer::addObject( SceneDagNode* parent, 
		SceneObject* obj, Material* mat ) {
	SceneDagNode* node = new SceneDagNode( obj, mat );
	node->parent = parent;
	node->next = NULL;
	node->child = NULL;
	
	// Add the object to the parent's child list, this means
	// whatever transformation applied to the parent will also
	// be applied to the child.
	if (parent->child == NULL) {
		parent->child = node;
	}
	else {
		parent = parent->child;
		while (parent->next != NULL) {
			parent = parent->next;
		}
		parent->next = node;
	}
	
	return node;;
}

LightListNode* Raytracer::addLightSource( LightSource* light ) {
	LightListNode* tmp = _lightSource;
	_lightSource = new LightListNode( light, tmp );
	return _lightSource;
}

void Raytracer::rotate( SceneDagNode* node, char axis, double angle ) {
	Matrix4x4 rotation;
	double toRadian = 2*M_PI/360.0;
	int i;
	
	for (i = 0; i < 2; i++) {
		switch(axis) {
			case 'x':
				rotation[0][0] = 1;
				rotation[1][1] = cos(angle*toRadian);
				rotation[1][2] = -sin(angle*toRadian);
				rotation[2][1] = sin(angle*toRadian);
				rotation[2][2] = cos(angle*toRadian);
				rotation[3][3] = 1;
			break;
			case 'y':
				rotation[0][0] = cos(angle*toRadian);
				rotation[0][2] = sin(angle*toRadian);
				rotation[1][1] = 1;
				rotation[2][0] = -sin(angle*toRadian);
				rotation[2][2] = cos(angle*toRadian);
				rotation[3][3] = 1;
			break;
			case 'z':
				rotation[0][0] = cos(angle*toRadian);
				rotation[0][1] = -sin(angle*toRadian);
				rotation[1][0] = sin(angle*toRadian);
				rotation[1][1] = cos(angle*toRadian);
				rotation[2][2] = 1;
				rotation[3][3] = 1;
			break;
		}
		if (i == 0) {
		    node->trans = node->trans*rotation; 	
			angle = -angle;
		} 
		else {
			node->invtrans = rotation*node->invtrans; 
		}	
	}
}

void Raytracer::translate( SceneDagNode* node, Vector3D trans ) {
	Matrix4x4 translation;
	
	translation[0][3] = trans[0];
	translation[1][3] = trans[1];
	translation[2][3] = trans[2];
	node->trans = node->trans*translation; 	
	translation[0][3] = -trans[0];
	translation[1][3] = -trans[1];
	translation[2][3] = -trans[2];
	node->invtrans = translation*node->invtrans; 
}

void Raytracer::scale( SceneDagNode* node, Point3D origin, double factor[3] ) {
	Matrix4x4 scale;
	
	scale[0][0] = factor[0];
	scale[0][3] = origin[0] - factor[0] * origin[0];
	scale[1][1] = factor[1];
	scale[1][3] = origin[1] - factor[1] * origin[1];
	scale[2][2] = factor[2];
	scale[2][3] = origin[2] - factor[2] * origin[2];
	node->trans = node->trans*scale; 	
	scale[0][0] = 1/factor[0];
	scale[0][3] = origin[0] - 1/factor[0] * origin[0];
	scale[1][1] = 1/factor[1];
	scale[1][3] = origin[1] - 1/factor[1] * origin[1];
	scale[2][2] = 1/factor[2];
	scale[2][3] = origin[2] - 1/factor[2] * origin[2];
	node->invtrans = scale*node->invtrans; 
}

Matrix4x4 Raytracer::initInvViewMatrix( Point3D eye, Vector3D view, 
		Vector3D up ) {
	Matrix4x4 mat; 
	Vector3D w;
	view.normalize();
	up = up - up.dot(view)*view;
	up.normalize();
	w = view.cross(up);

	mat[0][0] = w[0];
	mat[1][0] = w[1];
	mat[2][0] = w[2];
	mat[0][1] = up[0];
	mat[1][1] = up[1];
	mat[2][1] = up[2];
	mat[0][2] = -view[0];
	mat[1][2] = -view[1];
	mat[2][2] = -view[2];
	mat[0][3] = eye[0];
	mat[1][3] = eye[1];
	mat[2][3] = eye[2];

	return mat; 
}

void Raytracer::traverseScene( SceneDagNode* node, Ray3D& ray ) {
	SceneDagNode *childPtr;

	// Applies transformation of the current node to the global
	// transformation matrices.
	_modelToWorld = _modelToWorld*node->trans;
	_worldToModel = node->invtrans*_worldToModel; 
	if (node->obj) {
		// Perform intersection.
		if (node->obj->intersect(ray, _worldToModel, _modelToWorld)) {
			ray.intersection.mat = node->mat;
		}
	}
	// Traverse the children.
	childPtr = node->child;
	while (childPtr != NULL) {
		traverseScene(childPtr, ray);
		childPtr = childPtr->next;
	}

	// Removes transformation of the current node from the global
	// transformation matrices.
	_worldToModel = node->trans*_worldToModel;
	_modelToWorld = _modelToWorld*node->invtrans;
}

void Raytracer::computeShading( Ray3D& ray ) {
	if(ray.intersection.none){return;}
	LightListNode* curLight = _lightSource;
	for (;;) {
		if (curLight == NULL) break;
		// Each lightSource provides its own shading function.

		// Implement shadows here if needed.

		curLight->light->shade(ray,this);
		curLight = curLight->next;
	}
}

double Raytracer::getlight(Ray3D& ray){
	// This function is mainly for calculate 
	// simple shadow effects
	double mt = ray.intersection.t_value;
	ray.intersection.none=true;
	traverseScene(_root,ray);

	int result = ray.intersection.t_value<mt ? 0.1:1.0;
	#ifdef NOSHADOW
	return 1.0;
	#endif
	return result;
}


void Raytracer::inittemptextureBuffer(){
	// This is temp buffer prepare for texture mapping
	// However the method is not fully functionize
	int numbytes = _scrWidth* _scrHeight * sizeof(unsigned char);
	_trbuffer = new unsigned char[numbytes];
	_tgbuffer = new unsigned char[numbytes];
	_tbbuffer = new unsigned char[numbytes];
	for (int i = 0; i < _scrHeight; i++) {
		for (int j = 0; j < _scrWidth; j++) {
			_trbuffer[i*_scrWidth+j] = 0;
			_tgbuffer[i*_scrWidth+j] = 0;
			_tbbuffer[i*_scrWidth+j] = 0;
		}
	}
}
void Raytracer::initPixelBuffer() {
		//Initialzing Buffer
		// if _anti = 0, regular buffer
		// else _anti >0, regular buffer + superbuffer
	if(_anti==0){
		//regular buffer
		int numbytes = _scrWidth* _scrHeight * sizeof(unsigned char);
		_rbuffer = new unsigned char[numbytes];
		_gbuffer = new unsigned char[numbytes];
		_bbuffer = new unsigned char[numbytes];
		for (int i = 0; i < _scrHeight; i++) {
			for (int j = 0; j < _scrWidth; j++) {
				_rbuffer[i*_scrWidth+j] = 0;
				_gbuffer[i*_scrWidth+j] = 0;
				_bbuffer[i*_scrWidth+j] = 0;
			}
		}
	}else{
		//regular buffer
		int numbytes = _scrWidth* _scrHeight*sizeof(unsigned char);
		_rbuffer = new unsigned char[numbytes];
		_gbuffer = new unsigned char[numbytes];
		_bbuffer = new unsigned char[numbytes];
		for (int i = 0; i < _scrHeight; i++) {
			for (int j = 0; j < _scrWidth; j++) {
				_rbuffer[i*_scrWidth+j] = 0;
				_gbuffer[i*_scrWidth+j] = 0;
				_bbuffer[i*_scrWidth+j] = 0;
			}
		}
		//supersamping buffer
		numbytes = _scrWidth*_scrHeight*sizeof(unsigned char)*pow(_anti,2);
		_srbuffer = new unsigned char[numbytes];
		_sgbuffer = new unsigned char[numbytes];
		_sbbuffer = new unsigned char[numbytes];
		for (int i = 0; i < _anti * _scrHeight; i++) {
			for (int j = 0; j < _anti * _scrWidth; j++) {
				_srbuffer[i*_scrWidth*_anti+j] = 0;
				_sgbuffer[i*_scrWidth*_anti+j] = 0;
				_sbbuffer[i*_scrWidth*_anti+j] = 0;
			}
		}
	}
}


void Raytracer::flushPixelBuffer(char *file_name) {
	bmp_write( file_name, _scrWidth, _scrHeight, _rbuffer, _gbuffer, _bbuffer );
	delete _rbuffer;
	delete _gbuffer;
	delete _bbuffer;
}

Colour Raytracer::shadeRay( Ray3D& ray ) {
	/**
	*	Extension features: Reflection and Refraction
	**/
	Colour col(0.0, 0.0, 0.0); 
	traverseScene(_root, ray); 
	
	// Don't bother shading if the ray didn't hit 
	// anything.
	if (!ray.intersection.none){
		computeShading(ray); 
		col = ray.col;
		// add reflection effects  
		// Check if enable reflection or not
		#ifdef RFAPPLY
		if((ray.intersection.mat->refint>= 0.01)&&(ray.ref<Maxref)){
			//set up necessarge parameters
			Vector3D n = ray.intersection.normal,
					 dir = ray.dir;
			n.normalize();
			dir.normalize();

			//calculate new ray direction, and use 0.01 as reflection factor
			Vector3D ndir = dir-(2*n.dot(dir)*n);
			Ray3D nray = Ray3D(ray.intersection.point+0.01*ndir,
				 			   ndir,
				 			   ray.ref+1,
				 			   ray.refa,
				 			   ray.c);

			//check new ray's render style before rendering
			Colour recurs = shadeRay(nray);

			//calculate result colour
			col=(1-(ray.intersection.mat->refint))*ray.col+
			 	 (ray.intersection.mat->refint)*recurs;
		}else{
			//default
			col=ray.col;
		}
		#else
		//default
		col = ray.col;
		#endif

		#ifdef RFAAPPLY
		//add refraction effects
		if((ray.intersection.mat->tint>=0.1)&&(ray.refa<Maxref+1)){
			//parameter settings
			Vector3D n = ray.intersection.normal,
					 dir = ray.dir;
			n.normalize();
			dir.normalize();

			//calcualte new direction
			Vector3D ndir = dir-(2*n.dot(dir)*n);
			ndir.normalize();

			//Calculate and normalize refraction direction
			double s1 = ray.c,
				   s2 = s1 >=0.99 ? ray.intersection.mat->cs : 1.0,
			       t1 = n.dot(dir)>0 ? acos(n.dot(dir)) : acos(n.dot(-dir)),
				   t2 = asin(s2*sin(t1)/s1);

			Vector3D refd = n.dot(dir)>0 ? (s2/s1)*ray.dir-
												((s2/s1)*cos(t1)-cos(t2))*n :
											(s2/s1)*ray.dir+
												((s2/s1)*cos(t1)-cos(t2))*n;
			refd.normalize();

			//Here using 0.00001 as refration factor
			Ray3D rray = Ray3D(ray.intersection.point + 0.00001*refd,
						  refd,
						  ray.ref,
						  ray.refa+1,
						  s2);

			//check new ray's render style before rendering
			Colour recurs2 = shadeRay(rray);

			//calculate result colour
			if(!rray.intersection.none){
				col = (1-ray.intersection.mat->tint)*col+
					  (ray.intersection.mat->tint)*recurs2;
			}
		}
		#endif
	}
	// You'll want to call shadeRay recursively (with a different ray, 
	// of course) here to implement reflection/refraction effects.  

	return col; 
}	

void Raytracer::render( int width, int height, Point3D eye, Vector3D view, 
		Vector3D up, double fov, char* fileName, int anti) {
	//anti-alising disable
	if (anti==0){
		Matrix4x4 viewToWorld;
		_scrWidth = width;
		_scrHeight = height;
		_anti = 0;
		double factor = (double(height)/2)/tan(fov*M_PI/360.0);

		initPixelBuffer();
		viewToWorld = initInvViewMatrix(eye, view, up);

		// Constuct ray for each pixel
		for (int i = 0; i < _scrHeight; i++) {
			for (int j = 0; j < _scrWidth; j++) {
				// Sets up ray origin and direction in view space, 
				// image plane is at z = -1.
				Point3D origin(0, 0, 0);
				Point3D imagePlane;
				//apply factor on imageplane
				imagePlane[0] = (-double(width)/2 + 0.5 + j)/factor;
				imagePlane[1] = (-double(height)/2 + 0.5 + i)/factor;
				imagePlane[2] = -1;
				

				// hoot out ray with ray.dir as direction and ray.origin
				// as original point
				Ray3D ray;
            	ray.origin = viewToWorld * origin;
            	ray.dir = viewToWorld * imagePlane - ray.origin;
            	ray.dir.normalize();
				

				//check render style before rendering
				Colour col = shadeRay(ray); 

				//assign pixel buffer
				_rbuffer[i*_scrWidth+j] = int(col[0]*255);
				_gbuffer[i*_scrWidth+j] = int(col[1]*255);
				_bbuffer[i*_scrWidth+j] = int(col[2]*255);
			}
		}
		//output file and clean up buffers
		flushPixelBuffer(fileName);
	}else{
		// Anti-alising enable
		// Using supersampling method to sub-divide each pixal and 
		// then avg out amount of light then start rendering
		Matrix4x4 viewToWorld;
		_scrWidth = width;
		_scrHeight = height;
		_anti = anti;
		double factor = (double(_scrHeight)/2)/tan(fov*M_PI/360.0);

		initPixelBuffer();
		viewToWorld = initInvViewMatrix(eye, view, up);

		//set up necesary parameters for supersamping 
		int si, sj;
		double oi, oj;
		double cc = 1;
		unsigned long rt,gt,bt;	

		// Construct a ray for each pixel.
		for (int i = 0; i < _scrHeight; i++) {
			for (int j = 0; j < _scrWidth; j++) {
				// Here start sub-divide each pixel
				for (int a = 0; a < _anti; a++) {
					for (int b = 0; b < _anti; b++) {
						//divide each pixels into _anti^2 points
						Point3D origin(0, 0, 0);
						Point3D imagePlane;

						//offsets
						oj = cc/(_anti/2)+double(b)/_anti;
						oi = cc/(_anti/2)+double(a)/_anti;

						//apply factor on imagePlane
						imagePlane[0] = (-double((_scrWidth))/2+oj+j)/factor;
						imagePlane[1] = (-double((_scrHeight))/2+oi+i)/factor;
						imagePlane[2] = -1;

						//shoot ray at each sub-divided pixel
						Ray3D ray;
            			ray.origin = viewToWorld * origin;
            			ray.dir = viewToWorld * imagePlane - ray.origin;
            			ray.dir.normalize();
						
						//check render style before rendering
						Colour col = shadeRay(ray); 
						
						si = i*_anti+a,sj = j*_anti+b;
						
						// filling the super buffer prepare for future 
						// computation
						_srbuffer[si*_scrWidth*_anti+sj] = int(col[0]*255);
						_sgbuffer[si*_scrWidth*_anti+sj] = int(col[1]*255);
						_sbbuffer[si*_scrWidth*_anti+sj] = int(col[2]*255);				
					}
				}
			}
		}
		
		// Average all light sources in each pixel
		double factor1 = cc/pow(_anti,2);
		for (int i = 0; i < _scrHeight; i++) {
			for (int j = 0; j < _scrWidth; j++) {
				rt=gt=bt=0;
				for (int a = 0; a < _anti; a++) {
					si = i*_anti+a;
					for (int b = 0; b < _anti; b++) {
						sj = j*_anti+b;
						
						//sum all of sub-lights in each pixel
						rt += _srbuffer[si*_scrWidth*_anti+sj];
						gt += _sgbuffer[si*_scrWidth*_anti+sj];
						bt += _sbbuffer[si*_scrWidth*_anti+sj];
					}
				}
				//filling the regular buffer
				_rbuffer[i*_scrWidth+j] = factor1*rt;
				_gbuffer[i*_scrWidth+j] = factor1*gt;
				_bbuffer[i*_scrWidth+j] = factor1*bt;
			}
		}
		//output file and clean up buffers
		flushPixelBuffer(fileName);
	}
}

int main(int argc, char* argv[])
{	
	// Build your scene and setup your camera here, by calling 
	// functions from Raytracer.  The code here sets up an example
	// scene and renders it from two different view points, DO NOT
	// change this if you're just implementing part one of the 
	// assignment.  
	Raytracer raytracer;
	int width = 320; 
	int height = 240; 

	if (argc == 3) {
		width = atoi(argv[1]);
		height = atoi(argv[2]);
	}

	// Camera parameters.
	Point3D eye(0, 0, 5);
	Vector3D view(0, 0, -5);
	Vector3D up(0, 1, 0);
	double fov = 100;

	// Defines a material for shading.
	Material gold( Colour(0.3, 0.3, 0.3), Colour(0.75164, 0.60648, 0.22648), 
			Colour(0.628281, 0.555802, 0.366065), 
			51.2,0.001, 0.0, 1/2.4);
	Material jade( Colour(0, 0, 0), Colour(0.54, 0.89, 0.63), 
			Colour(0.316228, 0.316228, 0.316228), 
			12.8,0.2 , 0.0, 0.0);
	Material glass( Colour(0.15, 0.15, 0.15), Colour(0.08, 0.08, 0.08), 
			Colour(0.2, 0.2, 0.2),50.1,0.08,0.9,0.6667);
	Material obsidian(Colour(0.05375, 0.05, 0.06625), Colour(0.18275, 0.17, 0.22525),
			Colour(0.332741, 0.328634, 0.346435), 38.4, 0.05, 0.18, 0.413);
	

	PointLight *lights1 = new PointLight(Point3D(0, 0, 5), Colour(0.9, 0.9, 0.9));
	
	raytracer.addLightSource(lights1);
	
	SceneDagNode* cylinder = raytracer.addObject( new UnitCylinder(), &glass);
	double factor1[3] = { 0.5, 1.0, 0.5 };
	double factor2[3] = { 10.0, 10.0, 5.0 };

	raytracer.translate(cylinder, Vector3D(-0.5,0.5, 3.0));
	raytracer.rotate(cylinder, 'x', -45); 	
	raytracer.rotate(cylinder, 'y', -30); 
	raytracer.rotate(cylinder, 'z', 45); 
	raytracer.scale(cylinder, Point3D(0, 0, 0), factor1);

	SceneDagNode* wall1 = raytracer.addObject( new UnitSquare(), &jade );
	SceneDagNode* wall2 = raytracer.addObject( new UnitSquare(), &jade );


	raytracer.translate(wall1, Vector3D(0, 0, -2));
	raytracer.scale(wall1, Point3D(0, 0, 0), factor2);

	raytracer.translate(wall2, Vector3D(0, -3.0, 0.5));
	raytracer.rotate(wall2, 'x', 90); 
	raytracer.scale(wall2, Point3D(0, 0, 0), factor2);

	lights1->setshade(SHADE_MODE_P);	
	raytracer.render(width, height, eye, view, up, fov, "pretty.bmp",2);


	// Defines a point light source.
	// PointLight *lights = new PointLight(Point3D(0, 0, 5), Colour(0.9, 0.9, 0.9));
	// raytracer.addLightSource(lights);

	// //Add a unit square into the scene with material mat.
	// SceneDagNode* sphere = raytracer.addObject( new UnitSphere(), &gold);
	// //SceneDagNode* sphere1 = raytracer.addObject( new UnitSphere(), &brass);
	// SceneDagNode* plane = raytracer.addObject( new UnitSquare(), &jade);
	// // SceneDagNode* cylinder = raytracer.addObject( new UnitCylinder(), &brass);
	// // Apply some transformations to the unit square.
	// double factor1[3] = { 1.0, 2.0, 1.0 };
	// double factor2[3] = { 6.0, 6.0, 1.0 };
	// // double factor3[3] = { 0.5, 0.5, 2.0 };
	// raytracer.translate(sphere, Vector3D(0, 0, -5));
	// raytracer.rotate(sphere, 'x', -45); 
	// raytracer.rotate(sphere, 'z', 45); 
	// raytracer.scale(sphere, Point3D(0, 0, 0), factor1);

	// //raytracer.translate(sphere1, Vector3D(-2.5, 0, -5));	

	// raytracer.translate(plane, Vector3D(0, 0, -7));	
	// raytracer.rotate(plane, 'z', 45); 
	// raytracer.scale(plane, Point3D(0, 0, 0), factor2);

	// // raytracer.translate(cylinder, Vector3D(3, 0, -5));	
	// // raytracer.rotate(cylinder, 'z', 45); 
	// // raytracer.rotate(cylinder, 'x', -75); 
	// // raytracer.scale(cylinder, Point3D(0, 0, 0), factor3);

	// // #ifdef RFAAPPLY
	// // fprintf(stderr, "\there\n");
	// // #endif

	// // Render the scene, feel free to make the image smaller for
	// // testing purposes.
	// lights->setshade(SHADE_MODE_P);	
	// raytracer.render(width, height, eye, view, up, fov, "phong1.bmp",0);
	// raytracer.render(width, height, eye, view, up, fov, "phong1_anti.bmp",2);
	// lights->setshade(SHADE_MODE_S);	
	// raytracer.render(width, height, eye, view, up, fov, "sig1.bmp",0);
	// lights->setshade(SHADE_MODE_N);	
	// raytracer.render(width, height, eye, view, up, fov, "diffuse1.bmp",0);



	
	// // Render it from a different point of view.
	// Point3D eye2(4, 2, 1);
	// Vector3D view2(-4, -2, -6);
	// // Point3D eye2(-4, -2, 1);
	// // Vector3D view2(4, 2, -6);

	// lights->setshade(SHADE_MODE_P);	
	// raytracer.render(width, height, eye2, view2, up, fov, "phong2.bmp",0);
	// raytracer.render(width, height, eye2, view2, up, fov, "phong2_anti.bmp",2);
	// lights->setshade(SHADE_MODE_S);	
	// raytracer.render(width, height, eye2, view2, up, fov, "sig2.bmp",0);
	// lights->setshade(SHADE_MODE_N);	
	// raytracer.render(width, height, eye2, view2, up, fov, "diffuse2.bmp",0);

	
	return 0;
}

