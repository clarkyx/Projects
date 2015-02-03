/***********************************************************
     Starter code for Assignment 3

     This code was originally written by Jack Wang for
		    CSC418, SPRING 2005

		implements light_source.h

***********************************************************/

#include <cmath>
#include "light_source.h"
#include "raytracer.h"

void PointLight::shade(Ray3D& ray, Raytracer *newray) {
	// TODO: implement this function to fill in values for ray.col 
	// using phong shading.  Make sure your vectors are normalized, and
	// clamp colour values to 1.0.
	//
	// It is assumed at this point that the intersection information in ray 
	// is available.  So be sure that traverseScene() is called on the ray 
	// before this function.  
	
	//variable set up and normalization
	if (ray.intersection.none){return;}
	Vector3D n = ray.intersection.normal,
			 e = -ray.dir,
			 l = _pos-ray.intersection.point;

	n.normalize();
	e.normalize();
	l.normalize();

	//reflections
	Vector3D r = (2*n.dot(l))*n - l;

	Material *m = ray.intersection.mat;
	Colour c;
	//switch conditions for generating different light sourse in order
	// to produce different pictures
	double t1 = r.dot(e);
	double ma1 = t1>0? t1:0;
	double t2 = l.dot(n);
	double ma2 = t2>0? t2:0;

	//add shadow effects
	Ray3D nray= Ray3D(ray.intersection.point + 0.05*l,l);
	nray.intersection.t_value = (_pos-ray.intersection.point).length();
 	double trans=newray->getlight(nray);
	
	//calcualte base
	Colour basea = m->ambient*_col;
	Colour based = m->diffuse*_col;
	Colour bases = m->specular*_col;

	switch(_cases) {
		case SHADE_MODE_P:
			ray.col =ray.col+ basea+ trans*ma2*based+
				trans* pow(ma1,m->specular_exp)*bases;
			break;
		case SHADE_MODE_N:
			c= c +
				m->ambient*_col_ambient + 
				ma2*m->diffuse*_col_diffuse;
			break;
		case SHADE_MODE_S:
			ray.col = ray.col + m->diffuse;
	}
	ray.col = ray.col + c;
	ray.col.clamp();
}
