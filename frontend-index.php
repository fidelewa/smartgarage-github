<?php include('layout/header.php'); ?>
<?php 
$services = $wms->getAllActiveServiceList($link);
$sliders = $wms->getAllActiveSliderList($link);
$teams = $wms->getTeamWidgetHomeData($link);
$comments = $wms->getAllActiveCommentsList($link);
$gallery = $wms->galleryHomeView($link);
$news = $wms->getNewsDataForHomePage($link);
?>
<!-- banner slider Start Here -->
<?php if(!empty($sliders)) { ?>

<div class="banner">
  <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <?php
		   		$i = 0;
				foreach($sliders as $slider) {
		  			if($i == 0) {
						echo ' <li data-target="#carousel-example-generic" data-slide-to="'.$i.'" class="active"></li> ';
					} else {
						echo '<li data-target="#carousel-example-generic" data-slide-to="'.$i.'"></li> ';
					}
	      			$i++; 
				} 
		  ?>
    </ol>
    <!-- Wrapper for slides -->
    <div class="carousel-inner">
      <?php
		   		$i = 0;
				foreach($sliders as $slider) {
		  			if($i == 0) {
						if(!empty($slider['html_text'])) {
							echo '<div class="item active"> <img src="'.WEB_URL.'img/slider/'.$slider['slider_image'].'" alt="'.$slider['slider_text'].'">'.$slider['html_text'].'</div>';
						} else {
							echo '<div class="item active"> <img src="'.WEB_URL.'img/slider/'.$slider['slider_image'].'" alt="'.$slider['slider_text'].'"></div>';
						}
					} else {
						if(!empty($slider['html_text'])) {
							echo '<div class="item"> <img src="'.WEB_URL.'img/slider/'.$slider['slider_image'].'" alt="'.$slider['slider_text'].'">'.$slider['html_text'].'</div>';
						} else {
							echo '<div class="item"> <img src="'.WEB_URL.'img/slider/'.$slider['slider_image'].'" alt="'.$slider['slider_text'].'"></div>';
						}
					}
	      			$i++; 
				} 
			?>
    </div>
    <!-- Controls -->
    <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> </a> <a class="right carousel-control" href="#carousel-example-generic" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> </a> </div>
</div>
<?php } ?>
<!-- banner slider End Here -->
<!-- Our Services Section Start Here-->
<section class="our-causes">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-header section-header clearfix">
          <h2><strong> <?php echo $_lang['__service']; ?></strong></h2>
          <span class="decor"><span class="inner"></span></span> </div>
        <div class="row">
          <?php foreach($services as $service) { ?>
          <div class="col-sm-6 col-md-4 col-lg-4">
            <div class="item">
              <?php if(!empty($service['service_name'])) { ?>
              <div class="icon"> <span><img alt="<?php echo $service['service_name'];?>" src="<?php echo WEB_URL .'img/service/'.$service['image_url'];?>"></span> </div>
              <?php } ?>
              <div class="text">
                <div class="inner_area">
                  <?php if(!empty($service['seo_url'])) {?>
				  <h3><a href="<?php echo WEB_URL.'services/'.$service['seo_url']; ?>"><?php echo $service['service_name'];?></a></h3>
				  <?php } else {?>
				  <h3><?php echo $service['service_name'];?></h3>
				  <?php } ?>
                  <p><?php echo $service['short_description'];?></p>
                </div>
              </div>
            </div>
          </div>
          <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- Our Services Section End Here-->
<!-- Our Work Gallery -->
<?php if(!empty($gallery )) { ?>
<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-header section-header clearfix">
          <h2><strong> <?php echo $_lang['__work_gallery']; ?></strong></h2>
          <span class="decor"><span class="inner"></span></span> </div>
        <div class="row">
          <div class="col-md-12">
            <!-- Masonry Filter -->
            <ul class="list-inline masonry-filter text-center">
			  <li class="active"><a href="#" class="" data-filter="*"><span>All</span></a></li>
              <?php foreach($gallery as $gview) { ?>
              	<li><a href="#<?php echo $gview['class']; ?>" data-filter=".<?php echo $gview['class']; ?>" class=""><span><?php echo $gview['gallery_name']; ?></span></a></li>
			  <?php } ?>
            </ul>
            <!-- End Masonry Filter -->
            <!-- Masonry Grid -->
            <div id="grid" class="masonry-gallery grid-four-item clearfix" style="position: relative; height: 187.5px;">
              <!-- Masonry Item -->
              <?php foreach($gallery as $gview) { ?>
				  <?php foreach($gview['images'] as $images) { ?>
					  <div class="isotope-item <?php echo $gview['class']; ?>">
						<div class="ulockd-gallery-thumb"> <img class="img-responsive img-whp" src="<?php echo $images['image_url']; ?>" alt="<?php echo $images['text']; ?>">
						  <div class="layer">
							<h5><?php echo $images['text']; ?></h5>
							<div class="ulockd-overlay-icon"> <a class="popup-img" href="<?php echo $images['image_url']; ?>" title="<?php echo $images['text']; ?>"><i class="fa fa-camera"></i></a><!--<a class="link-btn" href="#"><i class="fa fa-link"></i></a>--></div>
						  </div>
						</div>
					  </div>
				  <?php } ?>
			  <?php } ?>
              <!-- Masonry Item -->
            </div>
            <!-- Masonry Gallery Grid Item -->
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>
<!-- END Our Work Gallery -->
<!-- WORK PROCESS -->
<?php if(file_exists(ROOT_PATH.'img/work_process/process.png')) { ?>
<section class="work_process">
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-header section-header clearfix">
          <h2><strong> <?php echo $_lang['__working_process']; ?></strong></h2>
          <span class="decor"><span class="inner"></span></span> </div>
        <div class="row">
          <div align="center"><img src="<?php echo WEB_URL.'img/work_process/process.png'; ?>"></div>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>
<!-- meet Notre équipe -->
<?php if(!empty($teams) && count($teams) > 0) { ?>
<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-header section-header clearfix">
          <h2><strong> <?php echo $_lang['__meet_specialist']; ?></strong></h2>
          <span class="decor"><span class="inner"></span></span> </div>
        <div class="row">
          <?php foreach($teams as $team) { ?>
		  <div class="col-xs-12 col-sm-6 col-md-3 cp-bottom-mobile-space">
            <div class="cp-team-member">
              <div class="cp-team-thumb"> <img class="img-responsive img-whp" src="<?php echo $team['image']; ?>" alt="<?php echo $team['name']; ?>">
                <?php if(!empty($team['link']) && $team['status']) { ?><div class="cp-team-overlay"><a href="<?php echo WEB_URL.'mechanic/'.$team['link']; ?>" title="Team Details"><i class="fa fa-link"></i></a></div><?php }?>
              </div>
              <div class="cp-team-mdetails">
                <div class="cp-member-name"><?php echo $team['name']; ?></div>
                <div class="cp-team-member-post"><?php echo $team['title']; ?></div>
              </div>
            </div>
          </div>
		  <?php }?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php }?>
<!--customer testimonials-->
<section class="cp-testimonial">
  <div class="overlay"></div>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="section-header-testimonial section-header clearfix">
          <h2><strong> <?php echo $_lang['__testomonial']; ?></strong></h2>
          <span class="decor"><span class="inner"></span></span> </div>
        <div class="row">
          <div class="col-md-12" data-wow-delay="0.2s">
            <div class="carousel slide" data-ride="carousel" id="quote-carousel">
              <ol class="carousel-indicators">
                <?php $x = 0; foreach($comments as $comment) { ?>
				<li data-target="#quote-carousel" data-slide-to="<?php echo $x; ?>" class="<?php if($x==0){echo 'active';}?>"><img class="img-responsive " src="<?php echo $comment['image_url'];?>"></li>
				<?php $x++;} ?>
              </ol>
              <!-- Carousel Slides / Quotes -->
              <div class="carousel-inner text-center">
                <?php $c = 0; foreach($comments as $comment) { ?>
				<div class="item <?php if($c==0){echo 'active';}?>">
                  <blockquote>
                    <div class="row">
                      <div class="col-sm-8 col-sm-offset-2">
                        <p><?php echo $comment['comments'];?></p>
                        <h4><?php echo $comment['author'];?></h4>
                        <small><?php echo $comment['profession'];?></small> </div>
                    </div>
                  </blockquote>
                </div>
				<?php $c++;} ?>
              </div>
              <a data-slide="prev" href="#quote-carousel" class="left carousel-control"><i class="fa fa-chevron-left"></i></a> <a data-slide="next" href="#quote-carousel" class="right carousel-control"><i class="fa fa-chevron-right"></i></a> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--end customer testimonials-->
<!--latest news block-->
<?php if(!empty($news)) { ?>
<section>
  <div class="container">
    <div class="row">
      <div class="col-xs-12">
        <div class="page-header section-header clearfix">
          <h2><strong> <?php echo $_lang['__news']; ?></strong></h2>
          <span class="decor"><span class="inner"></span></span> </div>
        <div class="row">
          <?php foreach($news as $newx) { ?>
		  <div class="col-md-4 col-sm-6 col-xs-12 cp-bottom-mobile-space mb-20">
            <div class="latest-single">
              <div class="ltst-img"> <img src="<?php echo $newx['thumb_image']?>" alt="<?php echo $newx['blog_title']; ?>"> </div>
              <div class="latest-content text-center">
                <div class="ltst-single">
                  <h6><a href="<?php echo WEB_URL.'news/'.$newx['category'].'/'.$newx['seo_url'];?>"><?php echo $newx['blog_title']; ?></a></h6>
                  <div class="ltst-post"> <span><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp; <?php echo $newx['blog_date_time']; ?></span>&nbsp; <span><i class="fa fa-comments-o" aria-hidden="true"></i>&nbsp; <?php echo $newx['comments']; ?> <?php echo (int)$newx['comments'] > 1 ? 'Comments' : 'Comment'; ?></span> </div>
                  <p><?php echo $newx['short_desc']?></p>
                  <div class="lastest-btn"> <a href="<?php echo WEB_URL.'news/'.$newx['category'].'/'.$newx['seo_url'];?>">READ MORE</a> </div>
                </div>
              </div>
            </div>
          </div>
		  <?php } ?>
        </div>
      </div>
    </div>
  </div>
</section>
<?php } ?>
<!-- Latest News Section End Here -->
</div>
<!--Content End Here -->
<?php $link = $wms->close_db_connection($link); ?>
<?php include('layout/footer.php'); ?>
