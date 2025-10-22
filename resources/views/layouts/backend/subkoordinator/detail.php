<?php  
/**
 * detail infografik, detail minigrafik
 */
?>
<?php 
/**
 * detail infografik microsite
 * greenpeace, perhutsos, riset inovasi
 */
$microsite_header_edsus = FALSE;
$microsite_artikel_terkait = FALSE; 

if(isset($microsite_name)){
    switch ($microsite_name) {
        case 'semarak-ramadan':
            $microsite_title = "Semarak Ramadan 1442 H";
            $microsite_slug = "semarak-ramadan";
            $microsite_type = "Edisi Khusus";
            $microsite_header_edsus = TRUE;
            $microsite_artikel_terkait = TRUE;
            break;
        case 'keuangan-syariah':
            $microsite_title = "Semarak Ramadan 1442 H";
            $microsite_slug = "semarak-ramadan";
            $microsite_type = "Edisi Khusus";
            $microsite_header_edsus = TRUE;
            $microsite_artikel_terkait = TRUE;
            break;
        case 'jelajahjalanrayapos':
            $microsite_title = "Jelajah Jalan Raya Pos";
            $microsite_slug = "jelajahjalanrayapos";
            $microsite_type = "Edisi Khusus";
            $microsite_header_edsus = TRUE;
            $microsite_artikel_terkait = TRUE;
            break;
        default:                
            $microsite_title = "";
            $microsite_slug = "";
            $microsite_type = "";
            break;
    }
} 
?>

<style>
 /* HEADER EDSUS */
 .header-edsus {
    background: #CCD4BC;
 }
 .label-header {
     margin-bottom: 0;
     font-size: 16px;
     padding-top: 10px;
     padding-bottom: 10px;
 }
 .label-header a{
    color: #000;
 }
 .nav-edsus>li>a{
    padding: 0;
 }
 .nav-edsus>li>a:focus,
 .nav-edsus>li>a:hover,
 .nav-edsus .open>a,
 .nav-edsus .open>a:focus,
 .nav-edsus .open>a:hover {
    background: none;
 }
 .nav-edsus .open>a span.caret,
 .nav-edsus .open>a:focus span.caret,
 .nav-edsus .open>a:hover span.caret{
    transform: rotate(180deg);
 }
 .nav-edsus{
     padding: 10px;
     background: #BBC3AD;
 }
 .nav-edsus .dropdown-menu{
     top: 160%;
     right: -10px;
     left: auto;
     width: 300px;
     padding-top: 0;
 }
 .nav-edsus .dropdown-menu .read{
 padding: 6px 20px;
 background: #F5F6F8;
 }
 .nav-edsus .dropdown-menu>li>a{
     padding: 7px 20px;
     white-space: normal;
 }
 .nav-edsus .dropdown-menu .divider{
 margin: 0;
 }
 .nav-edsus .btn-indeks{
     background: #969DF4;
     margin: 20px;
     color: #fff !important;
 }
 .nav-edsus .btn-indeks:hover{
    background: #969DF4 !important;
 }
 .nav-edsus .read p{
    padding-top: 5px;
 }

 /* INFO MICROSTE CORONA */
 .corona-info {
     display: inline-block;
     background-color: #e7f6a3;
     padding-top: 5px;
     padding-bottom: 5px;
     padding-right: 5px;
     padding-left: 15px;
     font-family: inter,sans-serif !important;
     font-size: 14px;
 }
 @media (max-width: 767px) {
     .detail-body iframe{
        height: 190px;
     }
 }
 </style>

<script>
    $(document).ready(function(){
        var id = '<?php echo isset($detail['id'])?$detail['id']:0; ?>';
        if (id != 0) {
            $.post('<?php echo base_url() ?>webservice/updateCountView',{id:id},function(data){ 

            });      
        };
        var meta_url = '<?php echo isset($meta_url)?$meta_url:''; ?>';
        if (meta_url != '') {$.post('<?php echo base_url() ?>webservice/reloadfb',{meta_url:meta_url},function(data){});}
    });
</script>

<?php if($microsite_header_edsus){ ?>
    <div class="header-edsus">
        <div class="container">
            <div class="row">
                <div class="col-md-10 label-header">
                    <strong><?php echo $microsite_type; ?></strong> | <a href="<?php echo base_url().$microsite_slug; ?>"><?php echo $microsite_title; ?></a>
                </div>
                <?php if($microsite_artikel_terkait){ ?>
                    <div class="col-md-2 hidden-xs">
                        <ul class="nav navbar-nav nav-edsus">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><strong>Tampilkan Artikel <span class="caret"></span></strong></a>
                                <ul class="dropdown-menu">
                                    <li class="read">
                                        <strong>Sedang dibaca:</strong>
                                        <p><?php echo isset($detail['title'])?clean_str($detail['title']):''; ?></p>
                                    </li>
                                    <li role="separator" class="divider"></li>
                                    <?php if (isset($listartikelmicrosite) && count($listartikelmicrosite)>0) { ?>
                                        <?php foreach ($listartikelmicrosite as $key => $value) { ?>
                                        <li><a href="<?php echo url_reformat_v3($value);?>"><?php echo isset($value['title'])?clean_str($value['title']):''; ?></a></li>
                                        <li role="separator" class="divider"></li>
                                        <?php } ?>
                                    <?php } ?>
                                    <li><a class="btn btn-indeks" href="<?php echo base_url().$microsite_slug; ?>">Beranda »</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php } ?>


<div class="border-bottom pb-3 mb-4">
    <div class="container">
        <div class="nav-kanal d-flex align-items-center position-relative">
            <div class="current-kanal mr-4 mr-xs-5 nowrap">
                <a href="<?php echo base_url('jurnalisme-data'); ?>"><a href="<?php echo base_url('jurnalisme-data'); ?>"><img class="current-kanal-icon" src="<?php echo $this->webconfig['frontend_template_v3_revamp'] ?>images/icons/icon-kanal-jurnalismedata@2x.png" alt="Icon kanal"></a></a>
                <a href="<?php echo base_url('jurnalisme-data'); ?>"><a href="<?php echo base_url('jurnalisme-data'); ?>"><div class="current-kanal-text d-inline">Jurnalisme Data</div></a></a>
            </div>
            <ul class="list-subkanal list-unstyled list-inline mb-0 horizontal-scroller">
                <li class="list-item <?php if($id_kanal && $id_kanal == $this->webconfig['kanal-id-infografik']){echo "active";} ?>"><div class="htag"><a href="<?php echo base_url() ?>infografik">Infografik</a></div></li>
                <li class="list-item"><div class="htag"><a href="<?php echo base_url() ?>analisisdata">Analisis</a></div></li>
            </ul>
        </div>
    </div>
</div>

<div class="detail-wrapper mt-4">
    <div class="container">
        <div class="row my-3">
            <div class="col-sm-12 col-md-7 col-lg-8 main-content mb-3">
                <article class="detail mb-5">
                    <section class="section-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>"><i class="glyphicon glyphicon-home"></i></a></li>                
                                <li class="breadcrumb-item"><div class="htag"><a href="<?php echo base_url('jurnalisme-data') ?>">Jurnalisme Data</a></div></li>
                                <li class="breadcrumb-item active" aria-current="page"><div class="htag"><a href="<?php echo breadcrumb($detail,'subkanal_url'); ?>">Infografik</a></div></li>
                            </ol>
                        </nav>
                    </section>
                    <h1 class="detail-title"><?php echo isset($detail['title'])?clean_str($detail['title']):''; ?></h1>
                    <div class="detail-summary">
                        <?php echo isset($detail['summary'])?clean_str($detail['summary']):''; ?>
                    </div>

                    <div class="detail-meta d-flex flex-column flex-xs-row justify-content-between mb-4">
                        <div class="detail-meta-left d-flex">
                            <div class="detail-author-image scale mr-3">                                
                                <?php if (isset($detail['penulis'][0]['path']) && $detail['penulis'][0]['path'] != '') { ?>
                                    <img class="img-fullwidth circle" src="<?php echo $this->webconfig['media-server-images'].$detail['penulis'][0]['path'] ?>" alt="<?php echo isset($detail['penulis'][0]['fullname'])?clean_str($detail['penulis'][0]['fullname']):''; ?>">
                                <?php }else{ ?>
                                    <img class="img-fullwidth circle" src="<?php echo $this->webconfig['frontend_template_v3_revamp'] ?>images/default-profile-picture.jpg" alt="Image title">
                                <?php } ?>
                            </div>
                            <div class="detail-meta-middle">
                                <div class="detail-author-name">
                                    <span class="text-gray">Oleh</span> <?php echo isset($detail['penulis'][0])?show_contributor_v3($detail['penulis'][0],"profile"):''; ?>
                                    <?php if(isset($detail['is_artikel_sponsor']) && $detail['is_artikel_sponsor']) { ?>
                                       <b> - <?php echo isset($detail['produser'][0]['fullname'])?clean_str($detail['produser'][0]['fullname']):$this->lang->line('publikasi_katadata'); ?></b>
                                    <?php } ?>
                                </div>
                                <div class="detail-date text-gray"><?php echo datetime_lang_reformat_long($detail['date_publish']) ?></div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3 mt-md-0">
                            <?php 
                                if(isset($detail['image']['is_old']) && $detail['image']['is_old'] == 1){
                                    $img_type = "img_old";
                                } else {
                                    $img_type = "img_ori";
                                }
                            ?>

                            <div class="bordered rounded px-3 py-2 mr-4 mb-2 mb-xs-0 align-self-center"><a class="link-download" href="<?php echo thumb_image($detail['image']['path'],'',$img_type) ?>" target="_blank" title="Unduh infografik ini"><i class="glyphicon glyphicon-download-alt"></i> Unduh</a></div>
                            <div class="detail-share icons align-self-center">
                                <a class="popup" rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo isset($meta_url)?$meta_url:''; ?>&title=<?php echo isset($meta_title)?clean_str($meta_title):''; ?>"><span class="icon-bg icon-facebook"></span></a>
                                <a class="popup" rel="nofollow" href="https://twitter.com/intent/tweet?text=<?php echo isset($meta_title)?convert_text(clean_str($meta_title)):''; ?>+<?php echo isset($meta_url)?$meta_url :''; ?>+via @KATADATAcoid ‏"><span class="icon-bg icon-twitter"></span></a>
                                <a class="popup" rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&title=<?php echo isset($meta_title)?urlencode(clean_str($detail['title'])):''; ?>&url=<?php echo isset($meta_url)?$meta_url :''; ?>"><span class="icon-bg icon-linkedin"></span></a>
                                <?php if ($this->agent->is_mobile()) { 
                                  $url_wa = "";
                                  $url_wa = "https://api.whatsapp.com/send";
                                  $tags_dflex = "d-flex";
                                 } else { 
                                  $url_wa = "";
                                  $url_wa = "https://web.whatsapp.com/send";
                                  $tags_dflex = "";
                                 } ?>
                                <a class="popup" rel="nofollow" href="<?php echo $url_wa; ?>?text=<?php echo isset($meta_title)?urlencode(clean_str($meta_title)):''; ?>%0a%0a<?php echo isset($meta_url)?urlencode($meta_url):''; ?>%0a%0a<?php echo isset($meta_desc)?urlencode(clean_str($meta_desc)):''; ?>%0a%0aPenulis: <?php echo isset($detail['penulis'][0]['fullname'])?clean_str($detail['penulis'][0]['fullname']):''; ?>%0aArtikel ini diterbitkan oleh Katadata"><span class="icon-bg icon-whatsapp"><i class="fa fa-whatsapp" aria-hidden="true"></i></span></a>
                            </div>
                        </div>
                    </div> 

                    <div class="detail-image mb-4">
                        <a class="fancybox" href="<?php echo thumb_image($detail['image']['path'],'',$img_type) ?>">
                            <img class="img-fullwidth bordered rounded" src="<?php echo thumb_image($detail['image']['path'],'',$img_type) ?>" alt="<?php echo imagecover_title($detail) ?>">
                        </a>
                    </div>

                    <div class="detail-body-wrapper">
                        <div class="detail-body mb-4">
                            <?php 
                            $body = htmlspecialchars_decode($detail['body']);
                            $contentpages = explode( "<!-- pagebreak -->", $body);
                            $perpage = 1;
                            $total_data = count($contentpages);

                            $closing_p = '</p>';
                            $paragraphs = explode( $closing_p, clean_str($contentpages[$page]) );

                            $insertion1 = $insertion2 = $insertion3 = $insertion4 = $insertion5 = $insertion6 = $insertion_vi_ai = '';

                            // iklan
                            // if ($this->webconfig['is_props'] == true) {
                            //     $insertion1 = '<div class="ads ads-728 ads-detail-body visible-lg py-4 text-center"  id="ads-5" ><div class="ads-inner"><a href="#" target="_blank"><img class="ads-image" src="https://cdn1.katadata.co.id/template/frontend_template_v3_revamp/images/ads-728x90.png" alt="Advertisement"></a></div></div>';
                            //     // $insertion1="<div class='center-belt'><div id='div-gpt-ad-leaderboard1' class='text-center'><script>googletag.cmd.push(function() { googletag.display('div-gpt-ad-leaderboard1'); });</script></div></div>";
                            // }

                            $insertion3 = widget_bacajuga($bacajuga);
                            $insertion6 = widget_bacajuga($bacajuga_publikasi);

                            $insertion_vi_ai = $this->load->sharedView('scripts/ads_vi_ai','',true);

                            // if ($this->webconfig['is_props'] == true) {
                            //     // $insertion2 = "<div class='center-belt text-center'><div id='div-gpt-ad-middle2'><script>googletag.cmd.push(function() { googletag.display('div-gpt-ad-middle2'); });</script></div></div>";
                            //     // $insertion6 = "<div class='center-belt text-center'><div id='div-gpt-ad-video' style='width: 1px; height: 1px;'><script>googletag.cmd.push(function() { googletag.display('div-gpt-ad-video'); });</script></div></div>";
                            //     $insertion6 = '<div class="ads ads-728 ads-detail-body visible-lg py-4 text-center"  id="ads-5" ><div class="ads-inner"><a href="#" target="_blank"><img class="ads-image" src="https://cdn1.katadata.co.id/template/frontend_template_v3_revamp/images/ads-728x90.png" alt="Advertisement"></a></div></div>';
                            // }

                            foreach ($paragraphs as $index => $paragraph) {
                                // Only add closing tag to non-empty paragraphs
                                if ( trim( $paragraph ) ) {
                                    // Adding closing markup now, rather than at implode,
                                    // means insertion is outside of the paragraph markup, and not just inside of it.
                                    $paragraphs[$index] .= $closing_p;
                                }

                                // first paragraph as 0  
                                if ( $index == 1) {
                                    // $paragraphs[$index] .= $newsletter_banner;
                                    $paragraphs[$index] .= $insertion1;
                                }                                                          
                                if ( $index == 2 && $detail['is_adv'] != 1) {
                                    $paragraphs[$index] .= $insertion3;
                                }
                                if ($index == 5 && $detail['is_adv'] != 1) {
                                    $paragraphs[$index] .= $insertion6;
                                    $paragraphs[$index] .= isset($script_artikel_mgid)?$script_artikel_mgid:'';
                                }
                                if ( $index == 5 && $detail['is_adv'] != 1) {
                                    $paragraphs[$index] .= $insertion_vi_ai;
                                }
                                if ( $index == 8 && $detail['is_adv'] != 1) {
                                    $paragraphs[$index] .= $insertion5;
                                }
                                
                                if (strtotime($detail['date_publish']) < strtotime(date('2020-07-17')) ) {
                                    if (strpos($paragraphs[$index], 'katadata.co.id') == false) {
                                        $paragraphs[$index] = str_replace('href', 'rel="nofollow" href', $paragraphs[$index]);
                                    }
                                }
                            }
                            echo implode( '', $paragraphs );

                            ?>
                            <?php 
                            // paging
                            if($total_data > 1){
                                $total_pages = ceil($total_data / $perpage);
                                $lastpage = $total_pages - 1;
                                
                                echo '<div class="kd-paging-nav center-block">';
                                    echo '<ul class="paging-wrapper">';
                                        if (isset($page) && $page != 0) {
                                            echo '<li class="pagination__item first">';
                                            echo "<a class='pagination__link first' href='".base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)."'></a>"; 
                                            echo '</li>';

                                            $prev_page = $page-1;
                                            echo '<li class="pagination__item previous">';
                                            echo "<a class='pagination__link previous' href='".base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$prev_page."'></a> "; 
                                            echo '</li>';
                                        }

                                        for ($i=0; $i<$total_pages; $i++) { 
                                            $pagingtext = $i+1;
                                           if($pagingtext == $page+1){
                                            $currentpage = "page-is-active";
                                            }else if($pagingtext > $page+2){
                                            $currentpage = 'hidden';
                                            }else if($page-2 > $pagingtext){
                                                $currentpage = 'hidden';
                                            } else {
                                                $currentpage = '';
                                            }

                                            echo '<li class="pagination__item '.$currentpage.'">';
                                            if($pagingtext == 1){
                                                echo "<a class='pagination__link' href='".base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4)."'>".$pagingtext."</a> "; 
                                            }else{
                                                echo "<a class='pagination__link' href='".base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$i."'>".$pagingtext."</a> "; 
                                            }
                                            echo '</li>';
                                        };
                                        
                                        if (isset($page) && $page != $lastpage) {
                                            $next_page = $page+1;
                                            echo '<li class="pagination__item next">';
                                            echo "<a class='pagination__link next' href='".base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$next_page."'></a> "; 
                                            echo '</li>';

                                            echo '<li class="pagination__item last">';
                                            echo "<a class='pagination__link last' href='".base_url().$this->uri->segment(1).'/'.$this->uri->segment(2).'/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$lastpage."'></a>"; 
                                            echo '</li>';
                                        }
                                    echo '</ul>';
                                echo '</div>';
                            }
                            ?>
                        </div>

                        <?php if (isset($detail['is_label_sponsor']) && $detail['is_label_sponsor'] == 1) { ?>
                            <?php if (isset($detail['advertiser']['path'])) { ?>
                                <img width="150" class="img-responsive mb-4" src="<?php echo $this->webconfig['media-server-advertiser'].$detail['advertiser']['path']; ?> ">
                            <?php } ?>
                        <?php } ?>

                        <?php // reporter
                          if (isset($detail['reporter']) && count($detail['reporter']) > 0) {
                            echo show_contributor_v3($detail['reporter'],"Reporter");
                          }
                        ?>
                        
                        <?php // editor
                          if (isset($detail['editor_new']) && count($detail['editor_new']) > 0 && !$editor_is_author) {
                            echo show_contributor_v3($detail['editor_new'],"Editor");
                          }
                        ?>

                        <?php
                          if (isset($detail['tagsarray']) && count($detail['tagsarray']) > 0) {
                            echo show_tags_list($detail['tagsarray']);
                          }
                        ?>

                        <?php echo $this->load->view('_content_label'); // bagiasa, gerakan3m, idekatadata2021 ?>

                        <?php $this->load->sharedView('widget_newsletter'); ?>
                    </div>
                </article>
            </div>

            <div class="col-sm-12 col-md-5 col-lg-4 sidebar mb-5">                
                <?php // topik terpopuler
                    if (isset($tag_populer) && count($tag_populer) > 0) {
                        echo widget($tag_populer,"tag_populer","sidebar");
                    }
                ?>

                <?php if ($this->webconfig['is_props'] == true) { ?>
                    <!-- MR 1 -->
                    <div class="ads ads-300 mb-5 py-4 text-center"  id="ads-sidebar-2" >
                        <div class="ads-inner">
                            <div id='div-gpt-ad-mr1'>
                                <script>
                                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-mr1'); });
                                </script>
                            </div>
                        </div>
                    </div>
                    <!-- MR 1 -->
                <?php }else{ ?>
                    <?php if (isset($iklansidebar1) && count($iklansidebar1)>0) { ?>
                        <div class="ads ads-300 mb-5 py-4 text-center"  id="ads-sidebar-2" >
                            <div class="ads-inner">
                              <?php echo tampil_iklan_v3($iklansidebar1); ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <section class="section-terpopuler pb-3" id="terpopuler">
                    <div class="d-flex align-items-center justify-content-between mb-4">
                        <h2 class="section-title mb-0">Infografik terpopuler</h2>
                    </div>
                    <?php 
                    if (isset($listterpopuler) && count($listterpopuler)) {
                        foreach ($listterpopuler as $key => $value) {
                            ?>
                            <article class="article d-flex mb-4">
                                <div class="content-image  flex-120  mr-4 scale">
                                    <a href="<?php echo url_reformat_v3($value) ?>">
                                        <img class="img-fullwidth rounded " src="<?php echo imagecover_url($value,'300x200') ?>" alt="<?php echo imagecover_title($value) ?>">
                                    </a>
                                </div>
                                <div class="content-text <?php if(isset($value['is_artikel_sponsor']) && $value['is_artikel_sponsor'] == 1){echo 'is-adv';} ?>">
                                    <h2 class="content-title fs-14 mb-3">
                                        <a href="<?php echo url_reformat_v3($value) ?>"><?php echo isset($value['title'])?clean_str($value['title']):''; ?></a>
                                    </h2>
                                </div>
                            </article>
                            <?php
                        }
                    }
                    ?>
                </section>

                <?php if ($this->webconfig['is_props'] == true) { ?>
                    <!-- MR 2 -->
                    <div class="ads ads-300 mb-5 py-4 text-center"  id="ads-sidebar-2" >
                        <div class="ads-inner">
                            <div id='div-gpt-ad-mr2'>
                                <script>
                                    googletag.cmd.push(function() { googletag.display('div-gpt-ad-mr2'); });
                                </script>
                            </div>
                        </div>
                    </div>
                    <!-- MR 2 -->
                <?php }else{ ?>
                    <?php if (isset($iklansidebar2) && count($iklansidebar2)>0) { ?>
                        <div class="ads ads-300 mb-5 py-4 text-center"  id="ads-sidebar-2" >
                            <div class="ads-inner">
                              <?php echo tampil_iklan_v3($iklansidebar2); ?>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
        <hr>
    </div>

    <section class="section-terkait my-5">
        <div class="container">
            <div class="row my-3">
                <div class="col-12 mb-3">
                    <div class="mb-4">
                        <h3 class="section-title">Infografik Terkait</h3>
                    </div>
                    <div class="latest-content">
                        <div class="row">
                        <?php 
                        if (isset($listberitaterkait) && count($listberitaterkait) > 0) {
                            foreach ($listberitaterkait as $key => $value) {
                                ?>
                                <div class="col-12 col-xs-4">
                                    <article class="article article--list bordered rounded">
                                        <div class="content-image position-relative mb-3 scale">
                                            <a href="<?php echo url_reformat_v3($value) ?>">
                                                <img class="img-fullwidth rounded" src="<?php echo imagecover_url($value,'620x413') ?>" alt="<?php echo imagecover_title($value) ?>">
                                            </a>
                                        </div>
                                        <div class="content-text px-3">
                                            <a href="<?php echo url_reformat_v3($value) ?>">
                                                <h3 class="content-title content-title--leveled fs-16 mb-5"><?php echo isset($value['title'])?clean_str($value['title']):''; ?></h3>
                                            </a>
                                        </div>
                                        <div class="d-flex flex-column flex-xs-row justify-content-between align-items-xs-center px-3 mb-3">
                                            <?php if (isset($value['image']['path']) && $value['image']['path'] != '') { ?>
                                                <a class="link-download mb-2 mb-xs-0" href="<?php echo thumb_image($value['image']['path'],'',"img_ori") ?>" target="_blank"><i class="glyphicon glyphicon-download-alt"></i> Unduh</a>
                                            <?php } ?>
                                            <div class="icons">
                                                <a class="popup" rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php echo url_reformat_v3($value); ?>&title=<?php echo isset($value['title'])?clean_str($value['title']):''; ?>"><span class="icon-bg icon-bg--small icon-facebook"></span></a>
                                                <a class="popup" rel="nofollow" href="https://twitter.com/intent/tweet?text=<?php echo isset($value['title'])?clean_str($value['title']):''; ?>+<?php echo url_reformat_v3($value) ?>+via @KATADATAcoid ‏"><span class="icon-bg icon-bg--small icon-twitter"></span></a>
                                                <a class="popup" rel="nofollow" href="https://www.linkedin.com/shareArticle?mini=true&title=<?php echo isset($value['title'])?clean_str($value['title']):''; ?>&url=<?php echo url_reformat_v3($value); ?>"><span class="icon-bg icon-bg--small icon-linkedin"></span></a>
                                            </div>
                                        </div>
                                    </article>
                                </div>
                                <?php
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- popin -->
            <?php $this->load->sharedView('scripts/ads_script_popin'); ?>
            <!-- end popin -->
        </div>
    </section>
</div>

<link rel="stylesheet" href="<?php echo $this->webconfig['frontend_template_v3_revamp'] ?>styles/jquery.fancybox.min.css">
<script src="<?php echo $this->webconfig['frontend_template_v3_revamp'] ?>scripts/jquery.fancybox.min.js"></script>

<?php echo isset($seo_script_detail)?$seo_script_detail:''?>
<?php echo isset($seo_script_scrolldepth)?$seo_script_scrolldepth:''?>