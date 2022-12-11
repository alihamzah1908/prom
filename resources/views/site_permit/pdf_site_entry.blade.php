<?php
    $r = request();
    $data = \App\Model\SiteEntry::where('id_site_entry', $r->id)->first();
    // if(!$data) $data = new \App\Model\SiteEntry;
    $site = isset($data->site)?$data->site:new \App\Model\Site;
    $region = isset($data->region)?$data->region:new \App\Model\Region;
    
    $data->personil = isset($data->personil)?$data->personil:'[]' ;
    $personils = json_decode($data->personil);
    if(!is_array($personils)){
        $personils = [$personils];
    }                        
    $p = 0;
?>
<head>
    <title>Site Entry PDF</title>
    <?php 
    $logo = url('adminlte/img/logo.png');
    $desc = "PALAPA RING OPERATION & MAINTENEANCE";
    ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:type" content="website" />
    <meta property="og:title" content="PROM" />
    <meta property="og:description" content="{{$desc}}" />
    <meta name="description" content="{{$desc}}" />
    <meta property="og:url" content="{{request()->path()}}" />
    <meta property="og:site_name" content="PROM" />
    <meta property="og:image" content="{{$logo}}" />
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:image:src" content="{{$logo}}">
    <meta name="twitter:description" content="{{$desc}}">
    <meta property="og:image:secure_url" content="{{$logo}}" />
    <meta property="og:image:width" content="1200" />
    <meta property="og:image:height" content="630" />
    <link rel="icon" href="{{$logo}}">
</head>

<style>
  .pcs-template {
    font-family: Open Sans, 'WebFont-Open Sans';
    font-size: 9pt;
    color: #333333;
    background: #ffffff;
  }

  .pcs-header-content {
    font-size: 9pt;
    color: #333333;
    background-color: #ffffff;
  }

  .pcs-template-body {
    /*padding: 0 0.400000in 0 0.550000in;*/
  }

  .pcs-template-footer {
    height: 0.700000in;
    font-size: 6pt;
    color: #aaaaaa;
    /*padding: 0 0.400000in 0 0.550000in;*/
    background-color: #ffffff;
  }
  .pcs-footer-content {
    word-wrap: break-word;
    color: #aaaaaa;
    border-top: 1px solid #adadad;
  }

  .pcs-label {
    color: #333333;
  }

  .pcs-entity-title {
    font-size: 20pt;
    color: #000000;
  }

  .pcs-orgname {
    font-size: 10pt;
    color: #333333;
  }

  .pcs-customer-name {
    font-size: 9pt;
    color: #333333;
  }

  .pcs-itemtable-header {
    font-size: 9pt;
    color: #ffffff;
    background-color: #3c3d3a;
  }

  .pcs-itemtable-breakword {
    word-wrap: break-word;
  }

  .pcs-taxtable-header {
    font-size: 9pt;
    color: #ffffff;
    background-color: #3c3d3a;
  }

  .breakrow-inside {
    page-break-inside: avoid;
  }

  .breakrow-after {
    page-break-after: auto;
  }

  .pcs-item-row {
    font-size: 9pt;
    border-bottom: 1px solid #adadad;
    background-color: #ffffff;
    color: #000000;
  }

  .pcs-item-sku {
    margin-top: 2px;
    font-size: 10px;
    color: #444444;
  }

  .pcs-item-desc {
    color: #727272;
    font-size: 9pt;
  }

  .pcs-balance {
    background-color: #f5f4f3;
    font-size: 9pt;
    color: #000000;
  }

  .pcs-totals {
    font-size: 9pt;
    color: #000000;
    background-color: #ffffff;
  }

  .pcs-notes {
    font-size: 8pt;
  }

  .pcs-terms {
    font-size: 8pt;
  }

  .pcs-header-first {
    background-color: #ffffff;
    font-size: 9pt;
    color: #333333;
    height: auto;
  }

  .pcs-status {
    color: ;
    font-size: 15pt;
    border: 3px solid;
    padding: 3px 8px;
  }

  .billto-section {
    padding-top: 0mm;
    padding-left: 0mm;
  }

  .shipto-section {
    padding-top: 0mm;
    padding-left: 0mm;
  }

  @page :first {
    @top-center {
      content: element(header);
    }

    margin-top: 0.700000in;
  }
  .pcs-template-header {
    /*padding: 0 0.400000in 0 0.550000in;*/
    height: 0.700000in;
  }
</style>
<style>
  .text-align-right {
    text-align: right;
  }
  .text-align-left {
    text-align: left;
  }
  .item-details-inline {
    display: inline-block;
    margin: 0 10px;
    vertical-align: top;
    max-width: 70%;
  }

  .total-in-words-container {
    width: 100%;
    margin-top: 10px;
  }

  .total-in-words-label {
    vertical-align: top;
    padding: 0 10px;
  }

  .total-in-words-value {
    width: 170px;
  }

  .total-section-label {
    padding: 5px 10px 5px 0;
    vertical-align: middle;
  }

  .total-section-value {
    width: 120px;
    vertical-align: middle;
    padding: 10px 10px 10px 5px;
  }

  .tax-summary-description {
    color: #727272;
    font-size: 8pt;
  }

  .bharatqr-bg {
    background-color: #f4f3f8;
  }

  .subject-block {
    margin-top: 20px;
  }

  .subject-block-value {
    word-wrap: break-word;
    white-space: pre-wrap;
    line-height: 14pt;
    margin-top: 5px;
  }

  .lineitem-header {
    padding: 5px 10px 5px 5px;
    word-wrap: break-word;
  }
  .lineitem-column {
    padding: 10px 10px 5px 10px;
    word-wrap: break-word;
    vertical-align: top;
  }

  .lineitem-content-right {
    padding: 10px 10px 10px 5px;
  }
  .total-number-section {
    width: 45%;
    padding: 10px 10px 3px 3px;
    font-size: 9pt;
    float: left;
  }
  .total-section {
    width: 50%;
    float: left;
  }
</style>
<style>
    .border-1{
        border:1px solid #000;
    }
    .border-2{
        border:2px solid #000;
    }
    .w100{
        width:100%;
    }
    .w90{
        width:90%;
        border-bottom:1px solid #000;
    }
    .w85{
        width:85%;
        border-bottom:1px solid #000;
    }
    .w75{
        width:75%;
        border-bottom:1px solid #000;
    }
    .w35{
        width:25%;
        border-bottom:1px solid #000;
    }
    .w25{
        width:25%;
        border-bottom:1px solid #000;
    }
    .w15{
        width:15%;
        border-bottom:1px solid #000;
    }
    .w10{
        width:15%;
        border-bottom:1px solid #000;
    }
    .row {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        margin-right: -7.5px;
        margin-left: -7.5px;
    }
    .col, .col-1, .col-10, .col-11, .col-12, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-auto, .col-lg, .col-lg-1, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-auto, .col-md, .col-md-1, .col-md-10, .col-md-11, .col-md-12, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-auto, .col-sm, .col-sm-1, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-auto, .col-xl, .col-xl-1, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-auto {
        position: relative;
        width: 100%;
        padding-right: 7.5px;
        padding-left: 7.5px;
    }
    .col-md-1 {
        -ms-flex: 0 0 8.333333%;
        flex: 0 0 8.333333%;
        max-width: 8.333333%;
    }
    .col-md-2 {
        -ms-flex: 0 0 16.666667%;
        flex: 0 0 16.666667%;
        max-width: 16.666667%;
    }
    .col-md-3 {
        -ms-flex: 0 0 25%;
        flex: 0 0 25%;
        max-width: 25%;
    }
    .col-md-4 {
        -ms-flex: 0 0 33.333333%;
        flex: 0 0 33.333333%;
        max-width: 33.333333%;
    }
    .col-md-5 {
        -ms-flex: 0 0 41.666667%;
        flex: 0 0 41.666667%;
        max-width: 41.666667%;
    }
    .col-md-9 {
        -ms-flex: 0 0 75%;
        flex: 0 0 75%;
        max-width: 75%;
    }
    *, ::after, ::before {
        box-sizing: border-box;
    }
    div {
        display: block;
    }
</style>

<div class="pdf-container center-container d-none d-md-block">
    <div>
        <div class="pcs-template">
            <div class="pcs-template-body border-2" style="padding:0.5rem; width:100%;">
                <table style="width:100%;table-layout: fixed; padding:2rem">
                    <tbody>
                        <tr>
                            <td style="vertical-align: top; width:50%;">
                                <div>
                                    <img src="http://prom.indonesiafintechforum.org/images/LEN_Telekomunikasi_Indonesia.png"  style="width:175.00px;height:60.00px;" id="logo_content">
                                </div>
                            </td>
                            <td style="width:50%;" class="text-align-right v-top">
                                <span class="pcs-entity-title">SITE ENTRY</span><br>
                                <span id="tmp_entity_number" style="font-size: 10pt;" class="pcs-label"><b> </b></span>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br><br>
                <div class="border-1 w100" style="padding:1rem">
                    <table class="border-1 w100" style="height:10%; padding:0.5rem">
                        <tbody>
                            <tr style="height:3%; border-bottom:1px solid #000;">
                                <td style="width:20%;">
                                    SITE
                                </td>
                                <td style="width:80%;">
                                    : {{$site->name_site}}
                                </td>
                            </tr>
                            <tr style="height:3%; border-bottom:1px solid #000;">
                                <td style="width:20%;">
                                    ID_SITE
                                </td>
                                <td style="width:80%;">
                                    : {{$site->site_id}}
                                </td>
                            </tr>
                            <tr style="height:4%; border-bottom:1px solid #000;">
                                <td style="width:20%;">
                                    Tujuan Kunjungan
                                </td>
                                <td style="width:80%;">
                                    : 
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <br><br>
                    <table class="w100" style="padding:0.5rem">
                        <tbody>
                            <tr style="height:3%">
                                <td class="w10"><b>Region</b></td>
                                <td class="w90"><b>: {{$region->region_name}}</b></td>
                            </tr>
                            <tr style="height:3%">
                                <td class="w25"><b>Entry DateTime</b></td>
                                <td class="w75"><b>: {{$data->entry_datetime}}</b></td>
                            </tr>
                            <tr style="height:3%;">
                                <td class="w25"><b>Description</b></td>
                                <td class="w75"><b>: {{$data->description}}</b></td>
                            </tr>
                            <tr style="height:3%">
                                <td style="width: 25%"><b>Personil</b></td>
                                <td style="width:75%">
                                    <table style="width:100%">
                                        <tbody>
                                            @foreach($personils as $key => $personil)
                                            <?php $personil = \App\User::where('id',$personil)->first(); ?>
                                            <tr>
                                               <td style="width:2%; text-align:right">
                                                   {{++$p}}
                                               </td>
                                               <td class="w35">
                                                   <b>{{isset($personil->name)?$personil->name:'DATA HAS BEEN DELETED'}}</b>
                                               </td> 
                                               <td style="width:8%; text-align:right">
                                                   No. Telp
                                               </td>
                                               <td class="w35">
                                                   <b>{{isset($personil->telpone)?$personil->telpone:'DATA HAS BEEN DELETED'}}</b>
                                               </td> 
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    
                </div>
                <br><br>
                <table class="border-1 w100" style="height:10%; padding:0.5rem">
                    <tbody>
                        <tr style="height:10%; border-bottom:1px solid #000;">
                            <td style="width:30%; text-align:left">
                                <div style="text-align:center">
                                    <b>Pemohon</b>
                                    <div style="width:80.00px;height:80.00px;"></div>
                                    <b>({{isset($data->createdBy)?$data->createdBy->name:'........................................'}})</b>
                                </div>
                            </td>
                            <td style="width:5%; text-align:right"></td>
                            <td style="width:30%; text-align:right">
                                <div style="text-align:center">
                                    <b>Pemberi Izin</b>
                                    <div style="width:80.00px;height:80.00px;"></div>
                                    <b>({{isset($data->approver1)?$data->approver1->name:'........................................'}})</b>
                                </div>
                            </td>
                            <td style="width:5%; text-align:right"></td>
                            <td style="width:30%; text-align:right">
                                <div style="text-align:center">
                                    <b>Pemberi Izin</b>
                                    <div style="width:80.00px;height:80.00px;"></div>
                                    <b>({{isset($data->approver2)?$data->approver2->name:'........................................'}})</b>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <br>
            </div>
        </div>
    </div>
</div>




