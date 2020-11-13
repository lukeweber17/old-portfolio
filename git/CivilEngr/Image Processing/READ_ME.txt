How to open and execute image processing script
1. Open Octave/Matlab
2. If "File Browser" window is not visible, make it visible by selecting "Show File Browser" under "Window" tab near the top of Octave/Matlab.
3. Navigate to the file directory containing "ImageProcessing.m" in the "File Browser" window.
4. Open "ImageProcessing.m" by double clicking on the file in in the "File Browser" window.
5. In the "File Browser" window, navigate to the file directory containing the file images you wish to process.
6. In the Editor tab, select "Save File and Run" button.  If a pop-up alerts you that the ".m" file is not in the selected file directory, choose to add the path to the directory.
7. Execute the image processing program by inputting the necessary details requested by the command prompt and/or pop-up windows.
	a. The "common image name" refers to the common name given to the images you want to process.  For example, if you have images with the names, "IMG_0024.jpg", "IMG_0025.jpg", "IMG_0026"... to "IMG_0080", you would type in "IMG_00".  Each time you want to submit an input in the command window, press the Enter key.  
	b. The number of the first and last image refers to the unique number identifiers for the first and last image you want to process. Using the given example in 7a, the number of the first image would be "24", and the number of the last image would be "80".  
	c. When prompted to select a sample pixel of the upper band and the lower band, which will be used as boundaries for cropping the image, click a location on the pop-up image that is a good representative of the requested bar as a whole.  NOTE: For good results, choose bands with distinct colors from the rest of the image (consider a bright orange or a bright green).
8. The processed images will appear in a folder named "NewImages" found in the same directory as the original images.