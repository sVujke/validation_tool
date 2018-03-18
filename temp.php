<?php

session_start();

$inputImagesDirectory = "data/images_input/";
$imagesInput = glob($inputImagesDirectory . "*.jpg");

foreach($imagesInput as $index => $imageInput)
{
   $imagesInput[$index]= str_replace('data/images_input/', '', $imageInput) ;
}


$layerMode="t";
$distanceMeasureMode="m";




if(isset($_POST['layerSelect'])){
    $_SESSION["mode"]=$_POST['layerSelect'];
}


if(isset($_SESSION["mode"])){
    $mode=$_SESSION["mode"];
}else
{
    $mode=$layerMode."_".$distanceMeasureMode;
}


$images=array();

function readImagesResult($mode,$imagesInput) {
    $images=array();
    if (($handle = fopen("data/data_input/".$mode.".csv", "r")) !== FALSE) {
        while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if(in_array($data[0],$imagesInput))
            {
                $images[$data[0]]=array_slice($data,1,20);
            }
        }
        fclose($handle);
    }
    return $images;
}
$images=readImagesResult($mode,$imagesInput);

$chosen_image='';
if(isset($_POST['submit'])){
    $data=$_POST["image_to_be_evaluated"];
    $chosen_image=$_POST['chosen_image'];
    include 'save_validation.php';

}
echo $mode;
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="style/main.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
    <title>Title</title>
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3"><form name="myform" action="" method="post">
                <select name="layerSelect" onchange="this.form.submit()">
                    <option value="t_m" <?php if($mode=="t_m") echo 'selected'; ?>>Transfer Layer, Manhattan</option>
                    <option value="t_e" <?php if($mode=="t_e") echo 'selected'; ?>>Transfer Layer, Euclidean</option>
                    <option value="t_c" <?php if($mode=="t_c") echo 'selected'; ?>>Transfer Layer, Cosine</option>

                    <option value="o_m" <?php if($mode=="o_m") echo 'selected';?>>Output Layer, Manhattan</option>
                    <option value="o_e" <?php if($mode=="o_e") echo 'selected';?>>Output Layer, Euclidean</option>
                    <option value="o_c" <?php if($mode=="o_c") echo 'selected';?>>Output Layer, Cosine</option>

                </select>
            </form></div>
            <div class="col-lg-6"><h2 class="text-center">Validate images</h2></div>
        </div>
        <div class="col-lg-3"></div>
        <div class="row">
            <div class="col-lg-4 center"><h4 class="text-left">Choose Image to validate</h4></div>
            <div class="col-lg-4">
                <div class="row">
                    <div class="col-lg-6 center ">
                        <select class="target">
                            <?php foreach($imagesInput as $key=>$value): ?>
                                <option value="<?php echo $value; ?>" <?php if($chosen_image==$value) echo 'selected'; ?>><?php echo $value; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-lg-6 hide">
                        <div class="small_img"><img src="data/images_database/003105.jpg"></div>
                    </div>
                </div>


            </div>
            <div class="col-lg-1"></div>
            <div class="col-lg-3 result center">
                <div class="rating text-center">
                    <h4>R@05:  <span class="rating_value_5" id="rating_value_5"></span>%</h4>
                </div>
                <div class="rating text-center">
                    <h4>R@10: <span class="rating_value_10" id="rating_value_10"></span>%</h4>
                </div>
                <div class="rating text-center">
                    <h4>R@20: <span class="rating_value_20" id="rating_value_20"></span>%</h4>
                </div>
            </div>
        </div>

        <?php foreach($images as $key=>$value): ?>
            <div id='<?php echo substr($key, 0, -4);?>' class='image_view'>

                <?php $index=1;
                foreach($value as $key2=>$value2): ?>
                <?php if($index==1){
                    echo '<div class="row">';
                    echo '<div class="col-lg-1"></div>';
                } ?>

                <div class="col-lg-2">
                    <img class="Rounded Corners" onmouseover='showOverlay("<?php echo substr($value2,0,-4);?>")' src='data/images_database/<?php echo $value2 ?>'>
                    <div class="overlay" id='<?php echo substr($value2, 0, -4);?>_overlay'>

                        <div class="align-middle row">
                            <div class="col-lg-3 text-center" ></div>
                            <div class="col-lg-2 text-center" ><h4 class="rating_input" onClick="rate(0,this)">0</h4></div>
                            <div class="col-lg-2 text-center" ><h4 class="rating_input" onClick="rate(1,this)">1</h4></div>
                            <div class="col-lg-2 text-center" ><h4 class="rating_input" onClick="rate(2,this)">2</h4></div>
                            <div class="col-lg-3 text-center" ></div>

                        </div>

                    </div>
                </div>
                <?php if($index==5){
                    echo '<div class="col-lg-1"></div>';
                    echo '</div>';
                    $index=0;
                }
                $index=$index+1;
                ?>
            <?php endforeach; ?>

        </div>

    <?php endforeach; ?>

    <div class="row">
        <div class="col-lg-10"></div>
        <div class="col-lg-2">
            <form name="myform3" action="" method="post">
                <input type="hidden" name="image_to_be_evaluated" id="image_to_be_evaluated" value="" >
                <input type="hidden" name="chosen_image" id="chosen_image" value="" >
                                <input type="hidden" name="layer" id="layer" value="" >
                                <input type="hidden" name="distance" id="layer" value="" >

                <input type="submit" name="submit" value="Save validation" onClick="updateHiddenField()">

            </form>
        </div>
    </div>
*
</div>
</body>
</html>
<script>

    var images = <?php echo json_encode($images); ?>;
    var rating_array = [];
    var chosen_image="";
    var rating_5=0;
    var rating_10=0;
    var rating_20=0;
    jQuery('#rating_value_20').html(sum_rating_20(rating_array));
    jQuery('#rating_value_10').html(sum_rating_10(rating_array));
    jQuery('#rating_value_5').html(sum_rating_5(rating_array));
    rating_20=sum_rating_20(rating_array);
    rating_10=sum_rating_10(rating_array);
    rating_5=sum_rating_5(rating_array);
    jQuery( ".target" ).change(function() {
        chosen_image=jQuery(this).val();
        jQuery('#chosen_image').val(chosen_image);
        showImagesForImagesWithID(chosen_image.substring(0,6));
        jQuery('#rating_value_20').html(sum_rating_20(rating_array));
        jQuery('#rating_value_10').html(sum_rating_10(rating_array));
        jQuery('#rating_value_5').html(sum_rating_5(rating_array));
        rating_20=sum_rating_20(rating_array);
        rating_10=sum_rating_10(rating_array);
        rating_5=sum_rating_5(rating_array);
    });
    jQuery( "body" ).ready(function() {
        chosen_image=jQuery('.target').val();
        jQuery('#chosen_image').val(chosen_image);
        showImagesForImagesWithID(chosen_image.substring(0,6));
        jQuery('#rating_value_20').html(sum_rating_20(rating_array));
        jQuery('#rating_value_10').html(sum_rating_10(rating_array));
        jQuery('#rating_value_5').html(sum_rating_5(rating_array));
        rating_20=sum_rating_20(rating_array);
        rating_10=sum_rating_10(rating_array);
        rating_5=sum_rating_5(rating_array);
    });

    function sum_rating_20(array)
    {
        out=0;
        for(var i=0;i<array.length;i++)
        {
            out+=array[i].rating;
        }
        //  out= Math.round(out * 1.0 / 40.0) *100
        return Math.round((out/40)*100);
    }
    function sum_rating_10(array)
    {
        out=0;
        if(array.length==0)
            return 0;
        for(var i=0;i<10;i++)
        {
            out+=array[i].rating;
        }
        //  out= Math.round(out * 1.0 / 40.0) *100
        return Math.round((out/20)*100);
    }
    function sum_rating_5(array)
    {
        out=0;
        if(array.length==0)
            return 0;
        for(var i=0;i<5;i++)
        {
            out+=array[i].rating;
        }

        //  out= Math.round(out * 1.0 / 40.0) *100
        return Math.round((out/10)*100);
    }
    function couple(image,rating)
    {
        return {"image":image,"rating":rating};
    }
    function showImagesForImagesWithID(image_class) {
        jQuery(".image_view").removeClass("show");
        jQuery('#'+image_class).addClass("show");
        rating_array=[];
        var current_images=images[image_class+'.jpg'];
        for(var i=0;i<current_images.length;i++)
        {
            rating_array[i]=couple(current_images[i],0);
        }
        jQuery('.small_img').parent().removeClass("hide");
        jQuery('.small_img > img').attr("src",'data/images_database/'+image_class+'.jpg');
    }
    function showOverlay(image_class) {
        jQuery(".overlay").removeClass("show");
        jQuery('#'+image_class+'_overlay').addClass("show");
    }

    function rate(rating,object)
    {
        jQuery(object).parent().parent().children().find(".rating_input").removeClass("rated");
        jQuery(object).addClass("rated");
        img_rating_id=jQuery(object).parent().parent().parent()[0].id.substring(0, 6)+".jpg";
        jQuery(object).parent().parent().parent().addClass("green_overlay");
        jQuery(object).parent().parent().parent().addClass("show2");

        for(var i=0;i<rating_array.length;i++)
        {
            if(rating_array[i].image==img_rating_id)
            {
                rating_array[i].rating=rating;
            }
        }
        jQuery('#rating_value_20').html(sum_rating_20(rating_array));
        jQuery('#rating_value_10').html(sum_rating_10(rating_array));
        jQuery('#rating_value_5').html(sum_rating_5(rating_array));
        rating_20=sum_rating_20(rating_array);
        rating_10=sum_rating_10(rating_array);
        rating_5=sum_rating_5(rating_array);
    }
    function updateHiddenField()
    {   
        jQuery('#image_to_be_evaluated').val(<?php echo "'".$mode.".csv'";?>+','+chosen_image+','+rating_5+','+rating_10+','+rating_20);
   }
</script>