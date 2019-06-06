<?php include('layout/header.php'); ?>
<?php
$result = array();
$latestPost = $wms->getFiveLatestNews($link);
$categories = $wms->getAllActiveServiceList($link);
$teams = $wms->getAllTeamMembers($link);
?>

<div class="page-title mechanic_profile">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Notre équipe</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo WEB_URL; ?>">Home</a></li>
          <li class="active"> Notre équipe</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="main-container">
  <div class="container ">
    <div class="content-placeholder">
      <div class="row">
        <div class="col-md-9 pr-50">
          <div class="row">
            <?php if(!empty($teams)) {?>
            <?php foreach($teams as $team) { ?>
            <div class="col-xs-12 col-sm-6 col-md-4 cp-bottom-mobile-space mb-x30">
              <div class="cp-team-member">
                <div class="cp-team-thumb"> <img class="img-responsive img-whp" src="<?php echo $team['image']; ?>" alt="<?php echo $team['name']; ?>">
                  <?php if(!empty($team['link'])) { ?>
                  <div class="cp-team-overlay"><a href="<?php echo WEB_URL.'mechanic/'.$team['link']; ?>" title="Team Details"><i class="fa fa-link"></i></a></div>
                  <?php }?>
                </div>
                <div class="cp-team-mdetails">
                  <div class="cp-member-name"><?php echo $team['name']; ?></div>
                  <div class="cp-team-member-post"><?php echo $team['title']; ?></div>
                </div>
              </div>
            </div>
            <?php }?>
            <?php } else  { ?>
            <div class="alert alert-success not_found_news"><i class="fa fa-info-circle"></i>aucune équipe trouvée.</div>
            <?php } ?>
          </div>
        </div>
        <div class="col-md-3 mt50">
          <div class="category-list mb-55-space">
            <div class="deatils-title">
              <h5><?php echo $_lang['__our_service']; ?></h5>
            </div>
            <ul class="category_tree">
              <?php foreach($categories as $category) { ?>
              <?php if(!empty($category['seo_url'])) {?>
              <li><a href="<?php echo WEB_URL.'services/'.$category['seo_url'];?>"><i class="fa fa-angle-double-right"></i>&nbsp; <?php echo $category['service_name'];?></a></li>
              <?php } else { ?>
              <li><a href="#"><i class="fa fa-angle-double-right"></i>&nbsp; <?php echo $category['service_name'];?></a></li>
              <?php } ?>
              <?php } ?>
            </ul>
          </div>
          <!--<div class="category-list mb-55-space">
            <div><img src="<?php //echo WEB_URL ;?>/img/offer.png" /></div>
          </div>-->
          <div class="latest-post-list">
            <div class="deatils-title">
              <h5><?php echo $_lang['__latest_post']; ?></h5>
            </div>
            <div class="latest-post-box">
              <!-- Lastest Post Single -->
              <?php foreach($latestPost as $lpost) { ?>
              <div class="latest-post-single mb-15">
                <div class="ltst-pst-img"> <img src="<?php echo $lpost['thumb_image']; ?>" alt="<?php echo $lpost['blog_title']; ?>"> </div>
                <div class="list_5_news">
                  <p><a href="<?php echo WEB_URL.'news/'.$lpost['category'].'/'.$lpost['seo_url'];?>"><?php echo $lpost['blog_title']; ?></a></p>
                  <div class="ltst-post"> <span><i class="fa fa-calendar" aria-hidden="true"></i>&nbsp; <?php echo $lpost['blog_date_time']; ?></span>&nbsp; <span><i class="fa fa-clock-o" aria-hidden="true"></i> <?php echo $lpost['blog_time']; ?></span> </div>
                </div>
              </div>
              <?php } ?>
              <!-- Lastest Post Single -->
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php $link = $wms->close_db_connection($link); ?>
<?php include('layout/footer.php'); ?>
