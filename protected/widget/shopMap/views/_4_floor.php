<div class="floor-inner-4 floor-inner">
    
    
    <div class="text-info-for-magazine-svg">
        <div class="text-info-svg">
            <a href="" class="shop-info-svg-title"></a>
            <div class="shop-info-svg-category"></div>
            <div class="shop-info-svg-time"></div>
        </div>
        
        <div class="text-info-svg-triangle"></div>

    </div> 
    
    <svg
   xmlns:dc="http://purl.org/dc/elements/1.1/"
   xmlns:cc="http://creativecommons.org/ns#"
   xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#"
   xmlns:svg="http://www.w3.org/2000/svg"
   xmlns="http://www.w3.org/2000/svg"
   xmlns:xlink="http://www.w3.org/1999/xlink"
   xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd"
   xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape"
   id="svg2995"
   version="1.1"
   inkscape:version="0.48.5 r10040"
   width="820"
   height="800"
   sodipodi:docname="3_floor.svg">
  <metadata
     id="metadata3001">
    <rdf:RDF>
      <cc:Work
         rdf:about="">
        <dc:format>image/svg+xml</dc:format>
        <dc:type
           rdf:resource="http://purl.org/dc/dcmitype/StillImage" />
        <dc:title></dc:title>
      </cc:Work>
    </rdf:RDF>
  </metadata>
  <defs
     id="defs2999" />
  <sodipodi:namedview
     pagecolor="#ffffff"
     bordercolor="#666666"
     borderopacity="1"
     objecttolerance="10"
     gridtolerance="10"
     guidetolerance="10"
     inkscape:pageopacity="0"
     inkscape:pageshadow="2"
     inkscape:window-width="1143"
     inkscape:window-height="756"
     id="namedview2997"
     showgrid="false"
     inkscape:zoom="0.417193"
     inkscape:cx="354.19622"
     inkscape:cy="330.58601"
     inkscape:window-x="166"
     inkscape:window-y="123"
     inkscape:window-maximized="0"
     inkscape:current-layer="layer1" />
  <g
     inkscape:groupmode="layer"
     id="layer35"
     inkscape:label="child">
    <path
       style="fill:#86378b;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
       d="m 324.86463,458.806 0,240.22155 421.19295,0 0,-198.04983 -60.52355,0 0,43.74475 -35.65496,0 0,-130.93461 -180.81127,0 0,-332.008201 186.44068,0 0,-57.20339 -380.08475,0 0,56.779661 150,0 L 425,458.68644 z"
       id="path3645"
       inkscape:connector-curvature="0"
       sodipodi:nodetypes="ccccccccccccccccc" />
    <text
       xml:space="preserve"
       style="font-size:20px;font-style:normal;font-weight:normal;text-align:center;line-height:125%;letter-spacing:0px;word-spacing:0px;text-anchor:middle;fill:#FFF;fill-opacity:1;stroke:none;font-family:Sans-serif"
       x="498.33194"
       y="578.28009"
       id="text3647"
       sodipodi:linespacing="125%"><tspan
         sodipodi:role="line"
         id="tspan3649"
         x="498.33194"
         y="578.28009">Детский городок</tspan><tspan
         sodipodi:role="line"
         x="498.33194"
         y="603.28009"
         id="tspan3651">&quot;ВАВИЛОНИЯ&quot;</tspan></text>
    <text
       xml:space="preserve"
       style="font-size:20px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#FFF;fill-opacity:1;stroke:none;font-family:Sans-serif"
       x="327.11865"
       y="56.779659"
       id="text3653"
       sodipodi:linespacing="125%"><tspan
         sodipodi:role="line"
         id="tspan3655"
         x="327.11865"
         y="56.779659">&quot;Вавилония&quot; детское кафе</tspan></text>
    <text
       xml:space="preserve"
       style="font-size:20px;font-style:normal;font-weight:normal;line-height:125%;letter-spacing:0px;word-spacing:0px;fill:#FFF;fill-opacity:1;stroke:none;font-family:Sans-serif"
       x="-341.44333"
       y="445.85291"
       id="text3657"
       sodipodi:linespacing="125%"
       transform="matrix(0,-1,1,0,0,0)"><tspan
         sodipodi:role="line"
         id="tspan3659"
         x="-341.44333"
         y="445.85291">Игровые автоматы</tspan></text>
  </g>
  <g
     inkscape:groupmode="layer"
     id="layer1"
     inkscape:label="floor"
     style="display:inline">
    <path
       style="fill:none;stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
       d="m 266.86914,22.219991 392.89744,-0.936317 0,479.987516 94.47071,0 0,210.59322 -23.30509,0 0,38.13559 -127.54237,0 0,-38.55932 -334.32971,0 0,78.97143 -136.02817,0 0,-79.10008 -75.504619,0 0,-493.77626 208.967279,-0.0375 z"
       id="path3006"
       inkscape:connector-curvature="0"
       sodipodi:nodetypes="ccccccccccccccccc" />
    
    <?php for($i = 6; $i <=6; $i++) : ?>
    <?php $shop = 'shop-' . $i; ?>
    <?php if(!empty($arguments['all_shop'][$shop])) : ?>
    <g
        link ="<?=(!empty($arguments['all_shop'][$shop]['link'])) ? $arguments['all_shop'][$shop]['link'] : '' ;?>"
        category="<?=(!empty($arguments['all_shop'][$shop]['shopCategory']['id_page'])) ? $arguments['all_shop'][$shop]['shopCategory']['id_page'] : '' ;?>"
        class="shop"
       inkscape:groupmode="layer"
       id="layer2"
       inkscape:label="<?=$shop?>">
      <path
         class='object-one <?= (!empty($arguments['all_shop'][$shop]['shopCategory']['color'])) ? $arguments['all_shop'][$shop]['shopCategory']['color'] : 'f19'?>'
         style="stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1"
         d="<?=$arguments['all_shop'][$shop]['path']?>"
         id="path3263"
         inkscape:connector-curvature="0"
         sodipodi:nodetypes="ccccc" />
      
      <g class="hidden-text">
          <text 
              data-x="<?=$arguments['all_shop'][$shop]['x']?>"
              data-y="<?=$arguments['all_shop'][$shop]['y']?>">
              <tspan class="title"><?=(!empty($arguments['all_shop'][$shop]['title'])) ? $arguments['all_shop'][$shop]['title'] : '';?></tspan>
              <tspan class="category"><?=magazine::getCategoryNameById($arguments['all_shop'][$shop]['category'])?></tspan>
              <tspan class="time"><?=(!empty($arguments['all_shop'][$shop]['operation_time'])) ? $arguments['all_shop'][$shop]['operation_time'] : '' ;?></tspan>
          </text>
      </g>   
      
      
      <?php if($arguments['all_shop'][$shop]['category'] != -4) : ?>
          <?php if($arguments['all_shop'][$shop]['type'] == 0) : ?>

            <circle 
                cx="<?=$arguments['all_shop'][$shop]['x']?>" 
                cy="<?=$arguments['all_shop'][$shop]['y']?>" 
                r="6" 
                style="fill:#fff; stroke:#000000;stroke-width:1px;stroke-linecap:butt;stroke-linejoin:miter;stroke-opacity:1" />

          <?php else :?>
          <g class="text-svg-title">
            
              <foreignObject
                x="<?=$arguments['all_shop'][$shop]['x'] - 100?>"
                y="<?=$arguments['all_shop'][$shop]['y']?>"
                width="250"
                height="60"
                >
                  <p xmlns="http://www.w3.org/1999/xhtml" class="text-for-svg-title">
                      <?= (!empty($arguments['all_shop'][$shop]['title'])) ? trim($arguments['all_shop'][$shop]['title']) : ''?>
                  </p>    
              </foreignObject>    
              
            
          </g>    

          <?php endif;?>
      <?php endif?>      
      
      
    </g>
    <?php endif;?>
    <?php endfor; ?>
    
    
  </g>
  
  
  <g
     inkscape:groupmode="layer"
     id="layer49"
     inkscape:label="stair">
    <image
       style="display:inline"
       y="-724.01697"
       x="716.99603"
       id="image3213-4-8-4"
       xlink:href="data:image/png;base64,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 "
       height="76"
       width="27.024914"
       transform="matrix(0,1,-1,0,0,0)" />
    <image
       style="display:inline"
       y="712.16101"
       x="610.04236"
       id="image3293"
       xlink:href="data:image/png;base64,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  "
       height="35"
       width="35" />
  </g>
  
  
  <g
     inkscape:groupmode="layer"
     id="layer47"
     inkscape:label="lift">
    <image
       y="505.0705"
       x="657.09161"
       id="image3869"
       xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAADAAAABECAYAAADHsbZQAAAABHNCSVQICAgIfAhkiAAABWpJREFU
aIHtm2toHFUUx38n2WyaBIvVoAUVWnxipaIf0vqo2CqKUNoPUixF8Iu1vooQUailQa2iiA9apQXx
gQhWxKqo4INaCBK1SqVYRG1ErRaflTZq28Q0e/xw7t1Md+/szmwm2RX2D5eZvffMnfOfuY9z/3dW
AFFVBRCRc4B5gAJjgNA4aHHHXar6hc/M+RMRWQ1sBL7EnJ+GEWkECPAvUADmisjDqroGAPfwV2DO
rsBICdAO5BsktWNvQIBrgGHgAec7bcAgsF5V+T8kYIl74LNbgBnAqUD/hF/01GE31sxn5bB2NQJ0
pa1FRE4BLsMewtfAgKqOZOhoHDoxAkdz1SxDEJFW4D7gVsx5gFFgj4j0qur7mbiZAC3VTY6FiOSA
rcBaxp0H60tzgPdE5DpnO+nDcGoCwC3A0io2T4vI6X5+mUykIiAi7cCqBKbTgWU1eZQSad/AGcBZ
CW17UtZdE9ISyAGtCW2T2k0IaQnsAX5IaPtNyrprQioCqnoEeDmh+Yvp3UmPWkahR4DPq9j0qeru
hhtGRURUdQi4GngLm8Gj+B1Yo6rrAaZiGE01E3uHVHU/sEREeoCFWBjyM/CqK5syJCYgIudis+1R
l6WY009iYUQXcKKInISFveLs96nqH1k6HUWQgGsqKiLdWLyzHDgZGxoLJeYFjIyP16NoBf4WkZ3A
BlXdntQxEelU1cPel0q23cBBYGlJzL0AGzI1w/Qs0JEg3t8EfATMjymfg/W/BUECwEXA4Yyd9+kV
IFfB+dsjtt8D3akIYM1g1yQ579MNMc6fGXhwmyoRCA2ji4DzA/lZYpWIhO79ENARsJ0XV1G0Et9R
5k/QuSS4AAsMixCRZcC1AdsWYGMM4WMIjLnjaVl4WAXtwEz/Q0ROwGb4OPQAvaGCEKvQkPVclRvE
4RdsAfRtSf4Y4w8M4B5gVpW61orIbHdeHK5DBMYCeduAd6vcIIR9wAsYkVJ4NfA84M4EdR0PrHPn
xRAmaSzUCRyX0DaKHLZubqtg04Wpbkng/S22kqShRK1RZdXrVHWHiCwCLgT+iTHrAA4Bb7rf7b6g
Jlkla6jqADCQ4pLig6k7AScUPAhcik2opW9NsWamwDpV7ScSj9WdAHAxyTox2GjVj4m7QG0rsqzx
FcnX2dvcMe8z6k5AVX8FVicw/RR43J0XW07dCQCo6tvA6xVMCkCvqvo5qjiMNgQBhzuwSDSEDW6k
KkOIwGQoCUnmg5+AvkDRIHB/3HWhaHRawC5POEaqhgK2rCydiXNEJqOiA6qPAZ+UZN+tqgfjbhAl
4KXAvQG7/SQP/KJoAw4Af5XkF7A4KYTbGBcOtqjqG1XuUbYim4F1KL9Y347FQtcTXl19DNwLDAXK
vnN1XhkpPwLcHLMiE3e8HLgR6KxpTRxZ1F8B5N3vlTEE+lz5j4GyvcD0yHJxMXB2Bpt8RQJlM7GX
MVT1w5KiuObi23doVvdyC6o6iHXITFHWrmuQA6sNxZMqLzbSPFATmgTqjSaBeqNJoN5oEqg3mgTq
jSaBeqNJoN5oEqg30hBopO+oi0hDIB+T79fCoS+02mPyM0MaAnHikq8jtI00QvknOVnAqx60uNRB
vC7p8Q6wM5DvhaetgbInVPVQjU5WwjCRt5sDdgCbE2oydwGvAY8Cc0vKlgNbXFo8Uf2ngg83YQLZ
TFFVRGQh8AG21f8SttXaRrkkchDrC35ncQhT8lqxTbhRbDsU4E9sZzOu76SBYHKjYqrdZmClqj4j
uH9wiMhVwFOYgjZMfP8YdSnH+H8NPAqMb5n6b/6zRB74Dfus7XkY1yIB+8gIuARjG9rwLpoSL1h5
QlkLWl7l/kxVD/jM/wAXJ4GitTkSTwAAAABJRU5ErkJggg==
"
       height="34"
       width="24" />
  </g>
  
</svg>
    
</div>    

