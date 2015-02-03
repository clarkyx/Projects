/***********************************************************
             CSC418/2504, Fall 2009
  
                 penguin.cpp
                 
       Simple demo program using OpenGL and the glut/glui 
       libraries

  
    Instructions:
        Please read the assignment page to determine 
        exactly what needs to be implemented.  Then read 
        over this file and become acquainted with its 
        design.

        Add source code where it appears appropriate. In
        particular, see lines marked 'TODO'.

        You should not need to change the overall structure
        of the program. However it should be clear what
        your changes do, and you should use sufficient comments
        to explain your code.  While the point of the assignment
        is to draw and animate the character, you will
        also be marked based on your design.

***********************************************************/

#ifdef _WIN32
#include <windows.h>
#endif

#include <GL/gl.h>
#include <GL/glu.h>
#include <GL/glut.h>
#include <GL/glui.h>

#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <map>
#include <math.h>

#ifndef _WIN32
#include <unistd.h>
#else
void usleep(unsigned int nanosec)
{
    Sleep(nanosec / 1000);
}
#endif


// *************** GLOBAL VARIABLES *************************


const float PI = 3.14159;

// --------------- USER INTERFACE VARIABLES -----------------

// Window settings
int windowID;               // Glut window ID (for display)
GLUI *glui;                 // Glui window (for controls)
int Win[2];                 // window (x,y) size


// ---------------- ANIMATION VARIABLES ---------------------

// Animation settings
int animate_mode = 0;       // 0 = no anim, 1 = animate
int animation_frame = 0;      // Specify current frame of animation

// Joint parameters
const float JOINT_MIN = -45.0f;
const float JOINT_MAX =  45.0f;
const float max_beak = 1.5f;
const float min_beak = 0.0f;
float rightfeet_rot = 0.0f;
float leftfeet_rot = 0.0f;
float rightleg_rot = 0.0f;
float leftleg_rot = 0.0f;
float arm_rot = 0.0f;
float neck_rot = 0.0f;
float upperbeak = 0.0f;
float lowerbeak = 0.0f;
std::map<std::string, float *> joint;
std::map<std::string, float *> joint2;
std::map<std::string, float *> joint3;



//////////////////////////////////////////////////////
// TODO: Add additional joint parameters here
//////////////////////////////////////////////////////



// ***********  FUNCTION HEADER DECLARATIONS ****************


// Initialization functions
void initGlut(char* winName);
void initGlui();
void initGl();


// Callbacks for handling events in glut
void myReshape(int w, int h);
void animate();
void display(void);

// Callback for handling events in glui
void GLUI_Control(int id);


// Functions to help draw the object
void drawSquare(float size);
void drawCircle(float r, int type);
void drawPolygonBody(float size, int type);
void drawhead();
void drawbeak();
void drawarms();
void drawlegs();


// Return the current system clock (in seconds)
double getTime();


// ******************** FUNCTIONS ************************



// main() function
// Initializes the user interface (and any user variables)
// then hands over control to the event handler, which calls 
// display() whenever the GL window needs to be redrawn.
int main(int argc, char** argv)
{

    // Process program arguments
    if(argc != 3) {
        printf("Usage: demo [width] [height]\n");
        printf("Using 300x200 window by default...\n");
        Win[0] = 300;
        Win[1] = 200;
    } else {
        Win[0] = atoi(argv[1]);
        Win[1] = atoi(argv[2]);
    }


    // Initialize glut, glui, and opengl
    glutInit(&argc, argv);
    initGlut(argv[0]);
    initGlui();
    initGl();

    // Invoke the standard GLUT main event loop
    glutMainLoop();

    return 0;         // never reached
}


// Initialize glut and create a window with the specified caption 
void initGlut(char* winName)
{
    // Set video mode: double-buffered, color, depth-buffered
    glutInitDisplayMode (GLUT_DOUBLE | GLUT_RGB | GLUT_DEPTH);

    // Create window
    glutInitWindowPosition (0, 0);
    glutInitWindowSize(Win[0],Win[1]);
    windowID = glutCreateWindow(winName);

    // Setup callback functions to handle events
    glutReshapeFunc(myReshape); // Call myReshape whenever window resized
    glutDisplayFunc(display);   // Call display whenever new frame needed 
}


// Quit button handler.  Called when the "quit" button is pressed.
void quitButton(int)
{
  exit(0);
}

// Animate button handler.  Called when the "animate" checkbox is pressed.
void animateButton(int)
{
  // synchronize variables that GLUT uses
  glui->sync_live();

  animation_frame = 0;
  if(animate_mode == 1) {
    // start animation
    GLUI_Master.set_glutIdleFunc(animate);
  } else {
    // stop animation
    GLUI_Master.set_glutIdleFunc(NULL);
  }
}

// Initialize GLUI and the user interface
void initGlui()
{
    GLUI_Master.set_glutIdleFunc(NULL);

    // Create GLUI window
    glui = GLUI_Master.create_glui("Glui Window", 0, Win[0]+10, 0);

    // Create a control to specify the rotation of the joint
    joint["neck"] = &neck_rot;
    joint["rightfeet"] = &rightfeet_rot;
    joint["leftfeet"] = &leftfeet_rot;
    joint["arm"] = &arm_rot;
    joint["leftleg"] = &leftleg_rot;
    joint["rightleg"] = &rightleg_rot;

    for (std::map<std::string, float *>::iterator i=joint.begin(); i!=joint.end(); ++i)
    {
    	GLUI_Spinner *joint_spinner
        	= glui->add_spinner(i->first.c_str(), GLUI_SPINNER_FLOAT, i->second);
        joint_spinner->set_speed(0.1);
        joint_spinner->set_float_limits(JOINT_MIN, JOINT_MAX, GLUI_LIMIT_CLAMP);
    }

    joint2["upperbeak"] = &upperbeak;
    joint3["lowerbeak"] = &lowerbeak;

    for (std::map<std::string, float *>::iterator i=joint2.begin(); i!=joint2.end(); ++i)
    {
    	GLUI_Spinner *joint_spinner
        	= glui->add_spinner(i->first.c_str(), GLUI_SPINNER_FLOAT, i->second);
        joint_spinner->set_speed(0.1);
        joint_spinner->set_float_limits(0.0f, 1.5f, GLUI_LIMIT_CLAMP);
    }

    for (std::map<std::string, float *>::iterator i=joint3.begin(); i!=joint3.end(); ++i)
    {
    	GLUI_Spinner *joint_spinner
        	= glui->add_spinner(i->first.c_str(), GLUI_SPINNER_FLOAT, i->second);
        joint_spinner->set_speed(0.1);
        joint_spinner->set_float_limits(-1.5f, 0.0f, GLUI_LIMIT_CLAMP);
    }


    ///////////////////////////////////////////////////////////
    // TODO: 
    //   Add controls for additional joints here
    ///////////////////////////////////////////////////////////

    // Add button to specify animation mode 
    glui->add_separator();
    glui->add_checkbox("Animate", &animate_mode, 0, animateButton);

    // Add "Quit" button
    glui->add_separator();
    glui->add_button("Quit", 0, quitButton);

    // Set the main window to be the "active" window
    glui->set_main_gfx_window(windowID);
}


// Performs most of the OpenGL intialization
void initGl(void)
{
    // glClearColor (red, green, blue, alpha)
    // Ignore the meaning of the 'alpha' value for now
    glClearColor(0.7f,0.7f,0.9f,1.0f);
}

const float scopewidth = 40.0f;
const float scopelength = 60.0f;
const float headsize = 25.0f;
const float beakwidth = 15.0f;
const float upperbeaklength = 5.0f;
const float lowerbeaklength = 3.0f;
const float armwidth = 15.0f;
const float armlength = 20.0f;
const float legwidth =  10.0f;
const float leglength = 20.0f;
const float feetwidth = 18.0f;
const float feetlength = 6.0f;




// Callback idle function for animating the scene
float boo = 0;
void animate()
{
    //Update geometry
    const double joint_rot_speed = 0.1;
    double joint_rot_t = (sin(animation_frame*joint_rot_speed) + 1.0) / 2.0;
    
    for (std::map<std::string, float *>::iterator i=joint.begin(); i!=joint.end(); ++i)
    {
    	*(i->second) = joint_rot_t*JOINT_MIN + (1- joint_rot_t) * JOINT_MAX;
    }

    if((*((joint2.begin())->second)>0)&&(*((joint2.begin())->second)<1.5)&&(boo==0))
    {
       *((joint2.begin())->second) = *((joint2.begin())->second) + 0.1;
    }

    if((*((joint2.begin())->second)>0)&&(*((joint2.begin())->second)<1.5)&&(boo==1))
    {
       *((joint2.begin())->second) = *((joint2.begin())->second) - 0.1;
    }


    if(*((joint2.begin())->second) == 0){
       *((joint2.begin())->second) = *((joint2.begin())->second) + 0.1;
       boo = 0;
    }

    if(*((joint2.begin())->second) == 1.5){
       *((joint2.begin())->second) = *((joint2.begin())->second) - 0.1;
       boo = 1;
    }

    *((joint3.begin())->second) = -(*((joint2.begin())->second));


    ///////////////////////////////////////////////////////////
    // TODO:
    //   Modify this function animate the character's joints
    //   Note: Nothing should be drawn in this function!  OpenGL drawing
    //   should only happen in the display() callback.
    ///////////////////////////////////////////////////////////

    // Update user interface
    glui->sync_live();

    // Tell glut window to update itself.  This will cause the display()
    // callback to be called, which renders the object (once you've written
    // the callback).
    glutSetWindow(windowID);
    glutPostRedisplay();

    // increment the frame number.
    animation_frame++;

    // Wait 50 ms between frames (20 frames per second)
    usleep(50000);
}


// Handles the window being resized by updating the viewport
// and projection matrices
void myReshape(int w, int h)
{
    // Setup projection matrix for new window
    glMatrixMode(GL_PROJECTION);
    glLoadIdentity();
    gluOrtho2D(-w/2, w/2, -h/2, h/2);

    // Update OpenGL viewport and internal variables
    glViewport(0,0, w,h);
    Win[0] = w;
    Win[1] = h;
}

void drawtorso()
{
	//Object Scope: Torso
	glPushMatrix();
		//Object Scope: Torso->Body
		glPushMatrix();
			glScalef(scopewidth,scopelength,1.0);
			glColor3f(1.0,1.0,0.0);
			drawPolygonBody(1.0, 1);
		glPopMatrix();
		drawhead();
		drawarms();
		drawlegs();
	glPopMatrix();
}

void drawhead()
{
	//Object Scope: head
	glPushMatrix();
		glTranslatef(0.0f,scopelength/2,0.0f);
		glRotatef(neck_rot,0.0,0.0,1.0);
		glPushMatrix();
			glTranslatef(0.0f,headsize/2 - 5,0.0f);
			glPushMatrix();
				glScalef(headsize,headsize,1.0);
				glColor3f(1.0f,1.0f,1.0f);
				drawPolygonBody(1.0, 3);
			glPopMatrix();
			//Object Scope: head->eye
			glPushMatrix();
				glTranslatef(-headsize/4,headsize/8 - 4, 0.0f);
				glPushMatrix();
					glColor3f(0.0f,0.0f,0.0f);
					drawCircle(3.0f, 1);
				glPopMatrix();
				//Object Scope: head->eye->eyeball
				glPushMatrix();
					glTranslatef(-headsize/4 + 4.5,headsize/8 - 4, 0.0f);
					glPushMatrix();
						glColor3f(0.0f,0.0f,0.0f);
						drawCircle(2.0, 2);
					glPopMatrix();
				glPopMatrix();
			glPopMatrix();
			glPushMatrix();
				glTranslatef(-headsize*12/16,-headsize/4, 0.0f);
				//Object Scope: head->upperbeak
				glPushMatrix();
					glTranslatef(0,upperbeaklength/2 + upperbeak, 0.0f);
					glPushMatrix();
						glScalef(beakwidth,upperbeaklength,1.0);
						glColor3f(0.0f,0.0f,0.0f);
						drawPolygonBody(1.0,4);
					glPopMatrix();
				glPopMatrix();
				//Object Scope: head->lowerbeak
				glPushMatrix();
					glTranslatef(0,lowerbeaklength/2 - 3 + lowerbeak, 0.0f);
					glPushMatrix();
						glScalef(beakwidth,lowerbeaklength,1.0);
						glColor3f(0.0f,0.0f,0.0f);
						drawSquare(1.0);
					glPopMatrix();
				glPopMatrix();
			glPopMatrix();	
		glPopMatrix();
		glColor3f(0.0f,0.0f,0.0f);
		drawCircle(3, 1);
	glPopMatrix();
}

void drawarms()
{
	//Object Scope: Torso->arm
	glPushMatrix();
		glTranslatef(0.0f,armlength/2,0.0f);
		glRotatef(arm_rot,0.0,0.0,1.0);
		glPushMatrix();
			glTranslatef(0.0f,-armlength/2,0.0f);
			glScalef(armwidth,armlength,1.0);
			glColor3f(1.0,0.1,1.0);
			drawPolygonBody(1.0, 2);
			glTranslatef(0.0f,armlength/2,0.0f);
		glPopMatrix();
		glColor3f(0.0f,0.0f,0.0f);
		drawCircle(3, 1);
	glPopMatrix();
}

void drawlegs()
{
	//Object Scope: Torso->left_leg
	glPushMatrix();
		glTranslatef(-scopewidth/4,-scopelength/4, 0.0f);
		glPushMatrix();
			glRotatef(leftleg_rot,0.0,0.0,1.0);
			glTranslatef(0.0f, -leglength/2, 0.0f);
			//Object Scope: Torso->left_leg->upper_left_leg
			glPushMatrix();
				glScalef(legwidth,leglength,1.0);
				glColor3f(1.0f,0.0f,0.0f);
				drawSquare(1.0);
			glPopMatrix();
			//Object Scope: Torso->left_leg->left_feet
			glPushMatrix();
				glTranslatef(0.0f,-leglength/2 + 3,0.0f);
				glRotatef(leftfeet_rot,0.0,0.0,1.0);
				glPushMatrix();
					glTranslatef(-feetwidth/2, 0.0f, 0.0f);
					glScalef(feetwidth,feetlength,1.0);
					glColor3f(1.0f,0.0f,0.0f);
					drawSquare(1.0);
				glPopMatrix();
				glColor3f(0.0f,0.0f,0.0f);
				drawCircle(3,1);
			glPopMatrix();
		glPopMatrix();
		glColor3f(0.0f,0.0f,0.0f);
		drawCircle(3,1);
	glPopMatrix();
	//Object Scope: Torso->right_leg
	glPushMatrix();
		glTranslatef(scopewidth/4,-scopelength/4, 0.0f);
		glPushMatrix();
			glRotatef(rightleg_rot,0.0,0.0,1.0);
			glTranslatef(0.0f, -leglength/2, 0.0f);
			//Object Scope: Torso->right_leg->upper_right_leg
			glPushMatrix();
				glScalef(legwidth,leglength,1.0);
				glColor3f(1.0f,0.0f,0.0f);
				drawSquare(1.0);
			glPopMatrix();
			//Object Scope: Torso->right_leg->right_feet
			glPushMatrix();
				glTranslatef(0.0f,-leglength/2 + 3,0.0f);
				glRotatef(rightfeet_rot,0.0,0.0,1.0);
				glPushMatrix();
					glTranslatef(-feetwidth/2, 0.0f, 0.0f);
					glScalef(feetwidth,feetlength,1.0);
					glColor3f(1.0f,0.0f,0.0f);
					drawSquare(1.0);
				glPopMatrix();
				glColor3f(0.0f,0.0f,0.0f);
				drawCircle(3,1);
			glPopMatrix();
		glPopMatrix();
		glColor3f(0.0f,0.0f,0.0f);
		drawCircle(3,1);
	glPopMatrix();
}



// display callback
//
// This gets called by the event handler to draw
// the scene, so this is where you need to build
// your scene -- make your changes and additions here.
// All rendering happens in this function.  For Assignment 1,
// updates to geometry should happen in the "animate" function.
void display(void)
{
    // glClearColor (red, green, blue, alpha)
    // Ignore the meaning of the 'alpha' value for now
    glClearColor(0.7f,0.7f,0.9f,1.0f);

    // OK, now clear the screen with the background colour
    glClear(GL_COLOR_BUFFER_BIT | GL_DEPTH_BUFFER_BIT);  

    // Setup the model-view transformation matrix
    glMatrixMode(GL_MODELVIEW);
    glLoadIdentity();

    ///////////////////////////////////////////////////////////
    // TODO:
    //   Modify this function draw the scene
    //   This should include function calls to pieces that
    //   apply the appropriate transformation matrice and
    //   render the individual body parts.
    ///////////////////////////////////////////////////////////


    // Push the current transformation matrix on the stack
    glPushMatrix();
    	drawtorso();
    // Retrieve the previous state of the transformation stack
    glPopMatrix();


    // Execute any GL functions that are in the queue just to be safe
    glFlush();

    // Now, show the frame buffer that we just drew into.
    // (this prevents flickering).
    glutSwapBuffers();
}


// Draw a square of the specified size, centered at the current location
void drawSquare(float width)
{
    // Draw the square
    glBegin(GL_POLYGON);
    glVertex2d(-width/2, -width/2);
    glVertex2d(width/2, -width/2);
    glVertex2d(width/2, width/2);
    glVertex2d(-width/2, width/2);
    glEnd();
}
// Draw a circle by using method by connecting multiple line segments,preset segments to 200
// in order to provide a smooth circle
void drawCircle(float radius,int type)
{
	int segments = 360;

	//type eye without filling and others
	if(type == 1){
	    glBegin(GL_LINE_LOOP);
	    for(int i = 0; i<segments;i++)
	    {
	    	float pi = 3.1415926535897932384626433832795;
	    	double head = i*pi/180;
	    	glVertex2d(cos(head)*radius, sin(head)*radius);
	    }
	    glEnd();
	}
	if (type == 2){
		glBegin(GL_TRIANGLE_FAN);
	    for(int i = 0; i<segments;i++)
	    {
	    	float pi = 3.1415926535897932384626433832795;
	    	double head = i*pi/180;
	    	glVertex2d(cos(head)*radius, sin(head)*radius);
	    }
	    glEnd();
	}
}

//Draw a polygon with providing 
void drawPolygonBody(float width, int type)
{
	//type1 body
	if (type == 1){
		glBegin(GL_POLYGON);
		glVertex2d(-width/4, width/2);
		glVertex2d(width/4, width/2);
		glVertex2d(width/2, -width/4);
		glVertex2d(width/4, -width/2);
		glVertex2d(-width/4, -width/2);
		glVertex2d(-width/2, -width/4);
		glEnd();
	}

	//type2 arm
	if(type == 2){
		glBegin(GL_POLYGON);
		glVertex2d(width/2, width/2);
		glVertex2d(width/4, -width/2);
		glVertex2d(-width/4, -width/2);
		glVertex2d(-width/2, width/2);
		glEnd();
	}

	//type3 head
	if(type == 3){
		glBegin(GL_POLYGON);
		glVertex2d(-width*7/16, 0.0f);
		glVertex2d(-width/8,width*3/8);
		glVertex2d(width*7/16, 0.0f);
		glVertex2d(width/2, -width/2);
		glVertex2d(-width/2, -width/2); 
		glEnd();
	}

	//type4 upperbeak
	if(type == 4){
		glBegin(GL_POLYGON);
		glVertex2d(-width/2, 0);
		glVertex2d(width/2, width/2);
		glVertex2d(width/2, -width/2);
		glVertex2d(-width/2,-width/2);
		glEnd();

	}
}


























