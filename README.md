# Simmilar Image Recommender - Validation Tool

## How it Works

This tool was built in order to facilitate the process of survaying people in order to compare different aproaches for recommending similar images for a particular image. 

![alt text](https://github.com/sVujke/validation_tool/blob/master/images_for_readme/interface.PNG "Validation Tool Interface")

The user selects:

* selects a method of providing similar images
* selects an image for validation (image for which the similar images are rendered)
* scores each image on scale (1-3) or (1-5)
* submits the scores

```
NOTE! By default, scale is set to 1-3. In casae you prefer the Likert scale use index1_5.php insted of index.php 
```

The system:

* calculates similarity@5, similarity@10 and similarity@20
* saves the output in the `output/` folder

```
NOTE! Manualy move the saved output to a new folder as the system will override previous results next time scores are submited. 
```


## Data Requirements

* Provide csv files with **indices** you want to compare in the `data/data_input/` directory. Incices row should be in form:
`0000.jpg, ... ,0020.jpg` where image at i=0 is the to be selected image and images i>0 are coresponding similar images.
![alt text](https://github.com/sVujke/validation_tool/blob/master/images_for_readme/selected_img.PNG "Validation Tool Interface")
* Provide images (for wich recommended similar images will be shown) in the  `data/images_input/` directory.
* Provide all images on which the KNN or ANN query was performed in the `data/images_database/`directory in order for all similar images to be rendered.
![alt text](https://github.com/sVujke/validation_tool/blob/master/images_for_readme/sim_images.PNG "Validation Tool Interface")



## Requirements

* PHP 
* JavaScript 

## Authors 
* @aelkindy
* @shohelahamad
* @sVujke
