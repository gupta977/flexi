<style>

/* Blur */
#blur img {
	-webkit-filter: blur(3px);
	filter: blur(3px);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
.flexi_gallery_child:hover #blur img {
	-webkit-filter: blur(0);
	filter: blur(0);
}

/* Gray Scale */
#gray img {
	-webkit-filter: grayscale(0);
	filter: grayscale(0);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;
}
.flexi_gallery_child:hover #gray img {
	-webkit-filter: grayscale(100%);
	filter: grayscale(100%);
}

/* Zoom In #1 */
#zoom img {
	-webkit-transform: scale(1);
	transform: scale(1);
	-webkit-transition: .3s ease-in-out;
	transition: .3s ease-in-out;

}
.flexi_gallery_child:hover #zoom img {
	-webkit-transform: scale(1.3);
	transform: scale(1.3);
}


.flexi_effect {
	width: 100%;
	height: 100%;
	margin: 0;
	padding: 0;
	background: #fff;
	overflow: hidden;
	position: relative;
}

/* Caption */

.caption1 {
  position: absolute;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5); /* Black see-through */
  width: 100%;
  transition: .5s ease-out;
  opacity:0;
  color: white;
  font-size: 20px;
  padding: 20px;
  text-align: center;
}

.flexi_gallery_child:hover .caption1 {
  opacity: 1;
}

/* ... common font style ... */
#flexi_title{
	overflow: hidden;
}

#flexi_title h3 {
  padding: 20px 0 5px;
  color: #fff;
  font-size: 24px;

  font-family: 'Open Sans', sans-serif;
  font-weight: 600;
}
#flexi_title p {
  color: #fff;

  font-family: 'Open Sans', sans-serif;
  font-weight: 400;
}

/* Simple caption */

.flexi_caption_1{
  position: absolute;
  top: 0;
  left: 0;
  z-index: 2;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,.6);
  -webkit-transition: .3s;
  transition: .3s;
  opacity: 0;
  text-align: center;
}
.flexi_gallery_child:hover .flexi_caption_1 {
  opacity: 1;
}

/* Drop down */
.flexi_caption_2 {
  position: absolute;
  top: -100%;
  left: 0;
  z-index: 2;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,.6);
  -webkit-transition: .3s;
  transition: .3s;
  opacity: 1;
  text-align: center;
}
.flexi_gallery_child:hover .flexi_caption_2 {
  top: 0;
  left: 0;
}

/* Movie caption */
.flexi_caption_3 {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 2;
  width: 100%;
  height: 100%;
  background: rgba(0,0,0,.6);
  -webkit-transition: .3s;
  transition: .3s;
  opacity: 0;
}
.flexi_caption_3 h3,
.flexi_caption_3 p {
  position: absolute;
  left: -100%;
  width: 260px;
  padding: 0;
  text-align: left;
  -webkit-transition: .3s;
  transition: .3s;
}
.flexi_caption_3 h3 {
  top: 30px;
}
.flexi_caption_3 p {
  top: 75px;
  font-size: 12px;
}
.flexi_gallery_child:hover .flexi_caption_3 {
  opacity: 1;
}
.flexi_gallery_child:hover .flexi_caption_3 h3,
.flexi_gallery_child:hover .flexi_caption_3 p {
  left: 20px;
}
.flexi_gallery_child:hover .flexi_caption_3 h3 {
  -webkit-transition-delay: .2s;
  transition-delay: .2s;
}
.flexi_gallery_child:hover .flexi_caption_3 p {
  -webkit-transition-delay: .5s;
  transition-delay: .5s;
}



    </style>
<div id="flexi_gallery">
<div class="pure-g" id="flexi_main_loop">
