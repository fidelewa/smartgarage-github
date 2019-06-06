<?php include('layout/header.php'); ?>
<?php include('library/pagination.php'); ?>
<?php
$pagination = new Pagination();
$limit = 3;
$page = 1;
if(isset($_GET['page']) && !empty($_GET['page'])) {
	$page = $_GET['page'];
}
//
$make = '';
$model = '';
$year = '';
$title = '';
$data = array(
	'make'	=> '',
	'model'	=> '',
	'year'	=> ''
);
if(isset($_GET['makeid']) && isset($_GET['modelid']) && isset($_GET['yearid'])) {
	$title = 'Make: '.$_GET['make'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Model: '.$_GET['model'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Year:'.$_GET['year'];
	$data = array(
		'make'	=> $_GET['makeid'],
		'model'	=> $_GET['modelid'],
		'year'	=> $_GET['yearid']
	);
	$pagination->url = WEB_URL.'filter-parts-collection?page={page}&make='.$_GET['make'].'&model='.$_GET['model'].'&year='.$_GET['year'].'&makeid='.$_GET['makeid'].'&modelid='.$_GET['modelid'].'&yearid='.$_GET['yearid'];
	
} else if(isset($_GET['makeid']) && isset($_GET['modelid'])) {
	$title = 'Make: '.$_GET['make'].'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Model: '.$_GET['model'];
	$data = array(
		'make'	=> $_GET['makeid'],
		'model'	=> $_GET['modelid'],
		'year'	=> ''
	);
	$pagination->url = WEB_URL.'filter-parts-collection?page={page}&make='.$_GET['make'].'&model='.$_GET['model'].'&makeid='.$_GET['makeid'].'&modelid='.$_GET['modelid'];
} else if(isset($_GET['makeid'])) {
	$title = 'Make: '.$_GET['make'];
	$data = array(
		'make'	=> $_GET['makeid'],
		'model'	=> '',
		'year'	=> ''
	);
	$pagination->url = WEB_URL.'filter-parts-collection?page={page}&make='.$_GET['make'].'&makeid='.$_GET['makeid'];
} else {
	$pagination->url = WEB_URL.'filter-parts-collection?page={page}';
}

$total = $wms->countAllPartsListByMakeModelYear($link, $data);
$pagination->total = $total;
$pagination->page = $page;
$pagination->limit = $limit;
$pagination = $pagination->render();

$result = array();
$latestPost = $wms->getFiveLatestNews($link);
$categories = $wms->getAllActiveServiceList($link);
$teams = $wms->getAllTeamMembers($link);
$parts = $wms->getAllPartsListByMakeModelYear($link, $page, $limit, $data);

?>

<div class="page-title mechanic_profile">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h1>Collection de pièces automobiles</h1>
        <ol class="breadcrumb">
          <li><a href="<?php echo WEB_URL; ?>">Home</a></li>
          <li class="active">Collection de pièces automobiles</li>
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
          <div id="contact_message" class="alert alert-success not_found_news"><i class="fa fa fa-envelope-o"></i>&nbsp;&nbsp;Si vous voulez acheter des pièces s'il vous plaît <a href="<?php echo WEB_URL;?>/contact-us" class="buy_request">contactez-nous </a> avec le nom et le numéro de pièce.</div>
          <div>
            <div class="row">
              <div class="col-md-12">
                <div class="result-sorting-wrapper">
                  <div class="sorting-count">
                    <p class="car_filter_title"><?php echo $title; ?></p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <?php foreach($parts as $aparts) {?>
              <div class="col-xs-12 col-md-6">
                <div class="product-content product-wrap clearfix">
                  <div class="row">
                    <div class="col-md-5 col-sm-12 col-xs-12">
                      <div class="product-image"> <img
src="<?php echo $aparts['parts_image']; ?>" alt="194x228" class="img-responsive">
                        <!--<span class="tag2 hot"> HOT </span>-->
                      </div>
                    </div>
                    <div class="col-md-7 col-sm-12 col-xs-12">
                      <div class="product-deatil">
                        <h5 class="name"><?php echo $aparts['parts_name']; ?></h5>
                        <p class="price-container"> <span><?php echo $currency. $aparts['parts_sell_price']; ?></span></p>
                        <span class="tag1"></span></div>
                      <div class="description">
                        <?php if($aparts['parts_condition']=='new') { ?>
                        <p><b>Condition:</b>
                          <label class="label label-success"><?php echo $aparts['parts_condition']; ?></label>
                        </p>
                        <?php } else { ?>
                        <p><b>Condition:</b>
                          <label class="label label-danger"><?php echo $aparts['parts_condition']; ?></label>
                        </p>
                        <?php } ?>
                        <p><b>Brand:</b>
                          <label class="label label-info"><?php echo $aparts['manufacturer_name']; ?></label>
                        </p>
                        <p><b>Warranty:</b>
                          <label class="label label-warning"><?php echo $aparts['parts_warranty']; ?></label>
                        </p>
                        <p><b>Part No:</b>
                          <label class="label label-danger"><?php echo $aparts['parts_sku']; ?></label>
                        </p>
                      </div>
                      <!--<div class="product-info smart-form">
                        <div class="row">
                          <div class="col-md-6 col-sm-6 col-xs-6">
                            <button class="add-cart" type="button">Add to cart</button>
                          </div>
                        </div>
                      </div>-->
                    </div>
                  </div>
                </div>
              </div>
              <?php } ?>
            </div>
            <div class="pag_top"><?php echo $pagination; ?></div>
          </div>
        </div>
        <div class="col-md-3 mt50">
          <div class="category-list mb-55-space">
            <div class="deatils-title">
              <h5><?php echo $_lang['__find_parts']; ?></h5>
            </div>
            <div>
              <div class="form-group select">
                <select onchange="loadModelData(this.value);" name="ddlMake" id="ddlMake" class="form-control">
                  <option value="">Sélectionnez Marque</option>
                  <?php 
					$results = $wms->getAllCarMakeList($link);
					foreach($results as $result) {
						echo "<option value='".$result['make_id']."'>".$result['make_name']."</option>";
				  } ?>
                </select>
              </div>
              <div class="form-group select">
                <select onchange="loadYearData(this.value);" name="ddlModel" id="ddlModel" class="form-control">
                  <option value="">Choisir un modèle</option>
                </select>
              </div>
              <div class="form-group select">
                <select name="ddlYear" id="ddlYear" class="form-control">
                  <option value="">Sélectionnez Année</option>
                </select>
              </div>
              <div class="form-group" align="center">
                <button onclick="filterPartsCollection();" class="btn_find_car" type="button"><i class="fa fa-wrench"></i>&nbsp;&nbsp; <?php echo $_lang['__find_parts_button']; ?></button>
              </div>
            </div>
          </div>
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
            <div><img src="<?php //WEB_URL; ?>img/offer.png" /></div>
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
