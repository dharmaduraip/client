
<?php if(count($feature_restaurants) > 0)
{ ?>
<div class="slider featured owl nearby_slider mt-0" id="oowlslider">
  <div class="container no_pad">
      <div class="slider-title">
    <h2>Featured Shops</h2>
  </div>
    <div class="feature foodimages owl-carousel" id="owl-demo">
      <?php foreach ($feature_restaurants as $key => $value) { ?>
        <div class="item">
          <div class="animation">
          <h4 class="add_newbanner"><a href="details/<?php echo $value->id; ?>" class="zoom"><img src="<?php echo $value->src; ?>" alt="Image" class="img-responsive imageeffect "></a></h4></div>
          <p>{!! $value->name !!}</p>
        </div>
     <?php  } ?>
    </div>
  </div>
</div>
<?php } ?>
<!-- <?php if(count($nearby_restaurants) > 0)
{ ?>
<div class="nearby slider mt-0" id="oowlslider">
  <div class="container no_pad">
    <div class="slider-title">
    <h2>Nearby Shops</h2>
  </div>
    <div class="foodimages owl-carousel" id="owl-demo">
      <?php foreach ($nearby_restaurants as $key => $value) { ?>
        <div class="item">
          <h4 class="add_newbanner"><a href="details/<?php echo $value->id; ?>" class="zoom"><img src="<?php echo $value->src; ?>" alt="Image" class="img-responsive imageeffect "></a></h4>
          <p>{!! $value->name !!}</p>
        </div>
     <?php  } ?>
    </div>
  </div>
</div>
<?php } ?> -->