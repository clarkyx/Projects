/***********************************************************
     Starter code for Assignment 3

     This code was originally written by Jack Wang for
		    CSC418, SPRING 2005

		implements scene_object.h

***********************************************************/

#include <cmath>
#include <iostream>
#include "scene_object.h"

bool UnitSquare::intersect( Ray3D& ray, const Matrix4x4& worldToModel,
		const Matrix4x4& modelToWorld ) {

	//Necessary variable set up
	Point3D origin = worldToModel*ray.origin;
	Vector3D originv = Vector3D(origin[0],origin[1],origin[2]);
	Vector3D dir = worldToModel*ray.dir;
	dir.normalize();
	Vector3D n = origin[2]>0 ? Vector3D(0,0,1):Vector3D(0,0,-1);

	//find intersection postion
	if (dir.dot(n)==0){return false;}
	double t = (-originv.dot(n))/(dir.dot(n));
	if (t<0){return false;}
	Point3D point = origin+t*dir;


	//if all condtions are satisfied, update
	if((std::abs(point[0])<=0.5 &&
	   std::abs(point[1])<=0.5) &&
	   (ray.intersection.none||ray.intersection.t_value>t)){
		//update
		ray.intersection.none = false;
		ray.intersection.point = modelToWorld*point;
		ray.intersection.normal = transNorm(worldToModel, n);
		ray.intersection.t_value = t;
		return true;
	}

	return false;
}

bool UnitSphere::intersect( Ray3D& ray, const Matrix4x4& worldToModel,
		const Matrix4x4& modelToWorld ) {
	//variable set up
	Point3D origin = worldToModel*ray.origin;
	Vector3D dir = worldToModel*ray.dir;

	//extra vector3d origin in order to use dot product function
	//in vector3d constuct
	Vector3D originv = Vector3D(origin[0],origin[1],origin[2]);


	// Using formula from textbook with fixed radius and 
	// origin 
	double a = dir.dot(originv),
		   b = dir.dot(dir),
		   c = originv.dot(originv)-1,
		   checker = a*a-b*c;

	// no intersecion, end function
	if(checker<0){return false;}

	//collision checker
	double cchecker = pow(checker, 0.5),
		   front = (-a+cchecker)/b,
		   back  = (-a-cchecker)/b;
	float  t        = back>=0 ? back:front;
	//check conditions for update
	if(t<0||(!ray.intersection.none && ray.intersection.t_value <= t)){return false;}

	//else, update
	Vector3D p = originv+t*dir;

	ray.intersection.none = false;
	ray.intersection.t_value = t;
	ray.intersection.point = modelToWorld*Point3D(p[0],p[1],p[2]);
	ray.intersection.normal = transNorm(worldToModel, p);

	return true;
}

//Advanced Feature: Cylinder
bool UnitCylinder::intersect(Ray3D& ray, const Matrix4x4& worldToModel,
		const Matrix4x4& modelToWorld){

	// variable setup
	Point3D origin = worldToModel*ray.origin;
	Vector3D originv = Vector3D(origin[0],origin[1],origin[2]);
	Vector3D dir = worldToModel*ray.dir;
	double limit = 0.000001;

	//discriminant for infinite cylinder and basic calulation from 
	//cylinder formula
	double a = dir.dot(dir)-pow(dir[2],2),
		   b = originv.dot(originv)-pow(originv[2],2),
		   c = dir.dot(originv)-dir[2]*originv[2],
		   checker = pow(originv[0]*dir[0]+originv[1]*dir[1],2)-
		   			     (dir[0]*dir[0]+dir[1]*dir[1])*
		   			     (originv[0]*originv[0]+originv[1]*originv[1]-1);

    // no intersection, end function
	if(checker<0){return false;}
	if(a>limit){
		//intersection on walls
		double cchecker = pow(checker,0.5),
			   front    = (-c+cchecker)/a,
			   back     = (-c-cchecker)/a,
			   tw       = back>0 ? back:front;

	    //ray is pointing away from walls, end function
		if(front<0||(!ray.intersection.none && ray.intersection.t_value <= tw)){return false;}			
		//normal and intersect point
		Vector3D p = originv+tw*dir,
			     n = Vector3D(p[0],p[1],0);
		n.normalize();

		if(p[2]<1&&
			p[2]>0){
			//update
			ray.intersection.none = false;
			ray.intersection.t_value = tw;
			ray.intersection.point = modelToWorld*Point3D(p[0],p[1],p[2]);
			ray.intersection.normal = transNorm(worldToModel, n);
			return true;	
		}
	}

	//parallel to caps
	if(dir[2]==0){return false;}

	//since above walls did not catch rays, now check caps
	double tc1 = (1-originv[2])/dir[2],
		   tc2 = -originv[2]/dir[2];

	//rays did not catch by caps either, end function
	if(tc1<0&&tc2<0){return false;}

	//check conditons for inside/outside
	double tc = tc1>tc2 ? tc2:tc1;
	if((tc1<0&&tc2>0)||(tc1>0&&tc2<0)){tc = tc1>tc2 ? tc1:tc2;}
	if(!ray.intersection.none && ray.intersection.t_value <= tc){return false;}
	
	Vector3D p = originv+tc*dir,
		     n = Vector3D(0,0,0);
	n[2] = p[2]<0.5 ? -1:1;

	if(pow(p[0],2)+pow(p[1],2)>=1){return false;}
	
	//otherwise update
	ray.intersection.none = false;
	ray.intersection.t_value = tc;
	ray.intersection.point = modelToWorld*Point3D(p[0],p[1],p[2]);
	ray.intersection.normal = transNorm(worldToModel, n);
	return true;
}

