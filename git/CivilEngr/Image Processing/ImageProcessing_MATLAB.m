% Chase Greenhagen
% CS 358
% Civil Engineering Project - MATLAB Version
% Image Cropping

%% How it works:
% This tool is meant for cropping images between two horizontal bars.
% This tool will request sample pixels of the top bar and the bottom bar.
% This tool will search for similar pixels that are within a tolerance.
% A bar is found if more than a MIN_BAR_PERCENT of pixels in a row of pixels
%   fit within the nTolerance pixel value.

%% clear workspace
clc;
clear;
close all;

% variables
sampleImage = true;   % variable for sampling image
nTolerance = 10;       % pixel tolerance for image processing
RTop = 0;                   % sample pixel Red value
GTop = 0;                   % sample pixel Green value
BTop = 0;                   % sample pixel Blue value
RBottom = 0;                % sample pixel Red value
GBottom = 0;                % sample pixel Green value
BBottom = 0;                % sample pixel Blue value
redoProcessing = false;

% create directory for new images
% check to see if folder already exists
if(exist('NewImages') ~= 7) 
  mkdir('NewImages');
end

% receive image names
sName = input('Please input the common image name: ','s');
nNumberF = input('Please input the number of the first image: ');
nNumberL = input('Please input the number of the last image: ');

% check if 
if( ( isinteger( uint8( nNumberF ) ) == false ) || ( isinteger( uint8( nNumberL ) ) == false ) ...
 || ( numel(nNumberF) ~= 1 ) || ( numel(nNumberL) ~= 1 ) )
  error('Entry error');
end

for(imageNum= uint8( nNumberF ):uint8( nNumberL ) )
  redoProcessing = true;
  while(redoProcessing == true)
    %% read in image
    % Checks to see if image exists as a file (2)
    bContinue = false;
    redoProcessing = false;
    if(exist([sName int2str( imageNum ) '.jpg'], 'file') == 2); 
      % if the file exists, create image names
      bContinue = true;
      imgName = [sName int2str( imageNum ) '.jpg'];
      testImg = imread(imgName);
    else % if the file does not exist
      ans = questdlg(['The following image does not exist:\n',...
      sName int2str( imageNum ) '.jpg\n' ...
      'Would you like to continue to the next image?'], 'Yes', 'No');
      
      % terminate program if user does not wish to continue
      if(strcmp(ans, 'Yes') == 0)
        error('Program terminated by user.');
      end
    end

    if(bContinue == true)
    
      % select sample pixel
      if(sampleImage == true)
        % Select sample pixel of bottom bar
        questdlg('Please select sample pixel of top bar.',...
            'Pixel Sample', 'Okay', 'Okay');
        imshow(testImg);
        [yTop, xTop, buttons] = ginput(1);
        xTop = ceil(xTop);
        yTop = ceil(yTop);
        % Calculate 
        RTop = testImg(xTop,yTop,1);
        GTop = testImg(xTop,yTop,2);
        BTop = testImg(xTop,yTop,3);
        % Select sample pixel of bottom bar
        questdlg('Please select sample pixel of bottom bar.', ...
            'Pixel Sample','Okay', 'Okay');
        figure(1);
        %imshow(testImg);
        [yBottom, xBottom, buttons] = ginput(1);
        xBottom = ceil(xBottom);
        yBottom = ceil(yBottom);
        % Calculate 
        RBottom = testImg(xBottom,yBottom,1);
        GBottom = testImg(xBottom,yBottom,2);
        BBottom = testImg(xBottom,yBottom,3);
        close(1);
        sampleImage = false;
      end
    
      % create binary image of upper band and display
      bwBandTop = (int8(testImg(:,:,1))-int8(RTop) > -nTolerance) & ...
      ((testImg(:,:,1))-(RTop) < nTolerance);%testImg(:,:,1) > 2*testImg(:,:,2);
      bwBandTop = bwBandTop &(int8(testImg(:,:,2))-int8(GTop) > -nTolerance) & ...
      (testImg(:,:,2)-GTop < nTolerance);%bwImgBand & ( testImg(:,:,1) > 7*testImg(:,:,3));
      bwBandTop = bwBandTop &(int8(testImg(:,:,3))-int8(BTop) > -nTolerance) & ...
      (testImg(:,:,3)-BTop < nTolerance);%bwImgBand & (testImg(:,:,1) > 200 );
      % create binary image of lower bar and display
      bwBandBottom = (int8(testImg(:,:,1))-int8(RBottom) > -nTolerance) & ...
      ((testImg(:,:,1))-(RBottom) < nTolerance);%testImg(:,:,1) > 2*testImg(:,:,2);
      bwBandBottom = bwBandBottom &(int8(testImg(:,:,2))-int8(GBottom) > -nTolerance) & ...
      (testImg(:,:,2)-GBottom < nTolerance);%bwImgBand & ( testImg(:,:,1) > 7*testImg(:,:,3));
      bwBandBottom = bwBandBottom &(int8(testImg(:,:,3))-int8(BBottom) > -nTolerance) & ...
      (testImg(:,:,3)-BBottom < nTolerance);%bwImgBand & (testImg(:,:,1) > 200 );

      % Or the binary bars
      bwImgBandB = bwBandBottom | bwBandTop;
      
      % Process image
      [y,x] = size(bwImgBandB);
      imSum = sum(bwImgBandB');  
      lowBar = 0;
      highBar = 0;

      for( i=1:y )
          if(imSum(i) < 0.3*x) %if less than 30 percent of pixels are highlighted
            bwImgBandB(i,:)=0;
          else
            bwImgBandB(i,:)=1;
            if( i < y/2 )
              highBar = i;
            else
              if( lowBar == 0 )
                lowBar = i;
              end
            end 
          end
      end
      %figure(2)
      %imshow(bwImgBandB);
      mFilter = strel('square', 20);
      bwImgBandB = imclose(bwImgBandB, mFilter);

      bError = true;
      if( ( highBar ~= 0 ) && ( lowBar > highBar ) )
        bError = false;
      end
      %% save image
      if(exist(['NewImages/' imgName]) == 2)
        ans = questdlg(['The following image already exists:\n',...
        ['NewImages/' imgName '\n'] ...
        'Would you like to overwrite this image?'], 'Yes', 'No');
        
        % if not yes, go to next iteration
        if(strcmp(ans, 'Yes') ~= 1)
          continue;
        end
      end
      % save image if no errors exist
      if( bError == false )
          imwrite(testImg(highBar:lowBar,:,:), ['NewImages/' imgName]);
          disp('Processed Image');
      else
          imwrite(testImg, ['NewImages/' imgName]);
          disp('Unprocessed Image');
          ans = questdlg(['The image remained unprocessed.  Would you like to choose new sample pixels and retry processing?'], 'Yes', 'No');
          % if yes
          if(strcmp(ans, 'Yes') == 1)
            sampleImage = true;
            redoProcessing = true;
          end
      end
    end
  end
end