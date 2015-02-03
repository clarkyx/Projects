/***********************************************************
     Starter code for Assignment 3

     This code was originally written by Jack Wang for
		    CSC418, SPRING 2005

		   light source classes

***********************************************************/

#ifndef _LIGHT_SOURCE_H_
#define _LIGHT_SOURCE_H_

#include "util.h"

class Raytracer;
// Base class for a light source.  You could define different types
// of lights here, but point light is sufficient for most scenes you
// might want to render.  Different light sources shade the ray 
// differently.
class LightSource {
public:
	virtual void shade( Ray3D&, Raytracer *newray) = 0;
	virtual Point3D get_position() const = 0; 
};
// for mode selection
typedef enum{
	SHADE_MODE_S=0,
	SHADE_MODE_P,
	SHADE_MODE_N
}sm;


// A point light is defined by its position in world space and its
// colour.
class PointLight : public LightSource {
public:
	PointLight( Point3D pos, Colour col ) : _pos(pos), _col_ambient(col), 
	_col_diffuse(col), _col_specular(col), _col(col) {}
	PointLight( Point3D pos, Colour ambient, Colour diffuse, Colour specular ) 
	: _pos(pos), _col_ambient(ambient), _col_diffuse(diffuse), 
	_col_specular(specular) {}
	void shade( Ray3D& ray,Raytracer *newray);
	void setshade(sm mode){_cases = mode;}
	Point3D get_position() const { return _pos; }
	
private:
	sm _cases;
	Point3D _pos;
	Colour _col_ambient;
	Colour _col_diffuse; 
	Colour _col_specular;	
	Colour _col; 
};

#endif
