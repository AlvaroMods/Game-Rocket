


<html>
 <head>
 <title>GAME BY ALVARO MODS</title>
 <body bgcolor="black"><!-- tok2_user_contents -->
<div id="tok2_user_contents">

  <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0"> 
 </head> 
 <body> 
  <canvas style="left:0;top:0;position:fixed;background:#333;"></canvas> 
  <script type="text/javascript">
var t = setInterval(function() {
if (innerWidth && innerHeight) {
w = innerWidth;
h = innerHeight;
x = Math.min(w, h);
score = 0;
speed = 1;
asteroids = [];
obstacles = [];
start = true;
gameover = false;
num = 16;
fly = false;
counter = 0;
color = "";
rgb = [250,250,250,1];
for (let i = 0; i < num; i++) {
asteroids.push(new Asteroid(rand(0,w),rand(0,h)));
}
init();
draw();
addEventListener("mousedown", function() {
song.play();
});
addEventListener("ontouchstart" in document?"touchstart":"mousedown", function() {
if (start || gameover) {
start = false;
gameover = false;
score = 0;
speed = 1;
player = new Ship(w/2, h/2);
for (let i = 0; i < num; i++) {
obstacles[i] = new Obstacle(w*2+i*x,rand(x/4,h-x/4),x/5);
}
}
fly = true;
});
addEventListener("ontouchstart" in document?"touchend":"mouseup", function() {
fly = false;
});
clearInterval(t);
}
});
function rand(min,max) {
return Math.random() * (max - min) + min;
}
function init() {
c = document.querySelector("canvas");
c.width = w;
c.height = h;
ctx = c.getContext("2d");
}
function draw() {
ctx.clearRect(0, 0, c.width, c.height);
for (let asteroid of asteroids)
asteroid.update();
if (start) {
ctx.beginPath();
ctx.fillStyle = "gold";
ctx.textBaseline = "middle";
ctx.textAlign = "center";
ctx.font = "bold " + x/6 + "px monospace";
ctx.fillText("GAME ROKET", c.width/2, c.height/4);
ctx.beginPath();
ctx.fillStyle = "white";
ctx.textBaseline = "middle";
ctx.textAlign = "center";
ctx.font = x/12 + "px monospace";
ctx.fillText(Date.now()%2000<1000?"SELAMAT DATANG DI GAME SAYA":"PENCET UNTUK MEMULAI", c.width/2, c.height/2);
} else if(gameover) {
ctx.beginPath();
ctx.fillStyle = "red";
ctx.textBaseline = "middle";
ctx.textAlign = "center";
ctx.font = "bold " + x/7 + "px monospace";
ctx.fillText("GAME ROKET", c.width/2, c.height/4);
ctx.beginPath();
ctx.fillStyle = "violet";
ctx.textBaseline = "middle";
ctx.textAlign = "center";
ctx.font = "bold "+x/9 + "px monospace";
ctx.fillText("Score: "+score, c.width/2, c.height/4*3);
ctx.beginPath();
ctx.fillStyle = "white";
ctx.textBaseline = "middle";
ctx.textAlign = "center";
ctx.font = x/12 + "px monospace";
ctx.fillText(Date.now()%2000<1000?"YAHH KALAH :(":"SKORE KAMU ADALAH", c.width/2, c.height/2);
} else {
changeColor();
for (let obstacle of obstacles)
obstacle.update();
player.update();
ctx.beginPath();
ctx.fillStyle = "violet";
ctx.textBaseline = "middle";
ctx.textAlign = "center";
ctx.font = "bold "+x/7 + "px monospace";
ctx.fillText(score, c.width/2, c.height/10);
}
requestAnimationFrame(draw);
}
function Asteroid(x,y) {
this.x = x;
this.y = y;
this.angle = 0;
}
Asteroid.prototype.draw = function() {
ctx.save();
ctx.beginPath();
ctx.translate(this.x, this.y);
ctx.rotate(this.angle);
ctx.fillStyle = "GREY";
for (let i = 0; i < 6; i++) {
i==0?ctx.moveTo(0.05*x*Math.cos(2*Math.PI*i/6), 0.05*x*Math.sin(2*Math.PI*i/6)):ctx.lineTo(0.05*x*Math.cos(2*Math.PI*i/6), 0.05*x*Math.sin(2*Math.PI*i/6));
}
ctx.closePath();
ctx.fill();
ctx.restore();
}
Asteroid.prototype.update = function() {
this.angle -= 0.01;
this.x -= x/360*speed;
if (this.x < -x/20) {
this.x = c.width+x/20;
this.y = rand(0,c.height);
}
this.draw();
}
function Ship(x,y) {
this.x = x;
this.y = y;
this.angle = 0;
this.velX = 0;
this.velY = 0;
}
Ship.prototype.draw = function() {
ctx.save();
ctx.translate(this.x, this.y);
ctx.rotate(this.angle);
ctx.beginPath();
ctx.fillStyle = "white";
ctx.moveTo(x/29,x/50);
ctx.lineTo(x/29,-x/50);
ctx.lineTo(-x/20,-x/56);
ctx.lineTo(-x/20,x/56);
ctx.closePath();
ctx.fill();
ctx.beginPath();
ctx.fillStyle = "red";
ctx.moveTo(-x/20,x/56);
ctx.lineTo(-x/18,x/28);
ctx.lineTo(0,x/50);
ctx.closePath();
ctx.fill();
ctx.beginPath();
ctx.fillStyle = "red";
ctx.moveTo(-x/20,-x/56);
ctx.lineTo(-x/18,-x/28);
ctx.lineTo(0,-x/50);
ctx.closePath();
ctx.fill();
ctx.beginPath();
ctx.fillStyle = "red";
ctx.moveTo(x/12,0);
ctx.lineTo(x/30,x/48);
ctx.lineTo(x/30,-x/48);
ctx.closePath();
ctx.fill();
ctx.beginPath();
ctx.fillStyle = "lightblue";
ctx.arc(x/84,0,x/100,0,2*Math.PI);
ctx.fill();
if (fly) {
ctx.beginPath();
ctx.fillStyle = "orange";
ctx.moveTo(-x/20,-x/72);
ctx.lineTo(-x/20,x/72);
ctx.lineTo(-x/9+rand(-x/128,x/128),0);
ctx.closePath();
ctx.fill();
}
ctx.beginPath();
ctx.rotate(Math.PI/2);
ctx.fillStyle = "black";
ctx.textBaseline = "middle";
ctx.textAlign = "center";
ctx.font = "bold " + (x/60) + "px monospace";
ctx.fillText("69", 0, x/32);
ctx.restore();
}
Ship.prototype.update = function() {
this.angle = Math.atan(this.velY/(x/160)) * 0.6;
if (fly) {
if (this.velY > 0) this.velY *= 0.8;
if (this.velY < x/90) this.velY -= x/900;
}
this.velY += x/1600;
this.x += this.velX;
this.y += this.velY;
this.draw();
}
function Obstacle(x,y,h) {
this.x = x;
this.y = y;
this.h = h;
this.passed = false;
}
Obstacle.prototype.draw = function() {
ctx.beginPath();
ctx.fillStyle = color;
ctx.moveTo(this.x,this.y);
ctx.lineTo(this.x + Math.tan(Math.PI/6)*(c.height-this.y),c.height);
ctx.lineTo(this.x - Math.tan(Math.PI/6)*(c.height-this.y),c.height);
ctx.closePath();
ctx.moveTo(this.x,this.y-this.h);
ctx.lineTo(this.x + Math.tan(Math.PI/6)*(this.y-this.h),0);
ctx.lineTo(this.x - Math.tan(Math.PI/6)*(this.y-this.h),0);
ctx.closePath();
ctx.fill();
}
Obstacle.prototype.detectCol = function() {
if (insidePath([this.x,this.y,this.x + Math.tan(Math.PI/6)*(c.height-this.y),c.height,this.x - Math.tan(Math.PI/6)*(c.height-this.y),c.height], player.x, player.y) || insidePath([this.x,this.y-this.h,this.x + Math.tan(Math.PI/6)*(this.y-this.h),0,this.x - Math.tan(Math.PI/6)*(this.y-this.h),0], player.x, player.y) || player.y > c.height || player.y < 0) {
gameover = true;
}
}
Obstacle.prototype.update = function() {
if (!this.passed) {
if (this.x < player.x) {
this.passed = true;
score++;
}
}
if (this.x < -x) {
this.passed = false;
this.x += x * num;
this.y = rand(x / 4, h - x / 4);
}
this.x -= speed * x / 120;
this.detectCol();
this.draw();
}
function changeColor() {
if (counter++ == 500) {
speed += 0.1 / speed;
counter = 0;
}
if (counter % 10 == 0) {
if (rgb[3]) {
if (rgb[0] < 250) {
rgb[0] += 2;
} else if (rgb[1] < 250) {
rgb[1] += 2;
} else if (rgb[2] < 250) {
rgb[2] += 2;
} else {
rgb[3] = 0;
}
} else {
if (rgb[0] > 100) {
rgb[0] -= 2;
} else if (rgb[1] > 100) {
rgb[1] -= 2;
} else if (rgb[2] > 100) {
rgb[2] -= 2;
} else {
rgb[3] = 1;
}
}
color = "rgb("  + rgb[0] + "," + rgb[1] + "," + rgb[2] + ")";
}
}
function insidePath(path, x, y) {
var count = 0;
var x1 = path[path.length - 2];
var y1 = path[path.length - 1];
var x2 = path[0];
var y2 = path[1];
if ((y - y1) * (y - y2) <= 0 && (x <= x1 || x <= x2) && (x1 >= x && x2 >= x || (x2 - x1) * (y - y1) / (y2 - y1) >= x - x1)) count++;
for (var i=2; i < path.length; i += 2) {
var x1 = path[i - 2];
var y1 = path[i - 1];
var x2 = path[i];
var y2 = path[i + 1];
if ((y - y1) * (y - y2) <= 0 && (x <= x1 || x <= x2) && (x1 >= x && x2 >= x || (x2 - x1) * (y - y1) / (y2 - y1) >= x - x1)) count++;
}
return count % 2;
}
</script> 
 <div style="text-align: right;position: fixed;z-index:9999999;bottom: 0;width: auto;right: 1%;cursor: pointer;line-height: 0;display:block !important;"><a title="Hosted on free web hosting 000webhost.com. Host your own website for FREE." target="_blank" href="https://www.000webhost.com/?utm_source=000webhostapp&utm_campaign=000_logo&utm_medium=website&utm_content=footer_img"><img src="https://alvarotools.nasiwebhost.com/20210319_161913.jpg" alt="www.000webhost.com"></a></div><script>function getCookie(t){for(var e=t+"=",n=decodeURIComponent(document.cookie).split(";"),o=0;o<n.length;o++){for(var i=n[o];" "==i.charAt(0);)i=i.substring(1);if(0==i.indexOf(e))return i.substring(e.length,i.length)}return""}getCookie("hostinger")&&(document.cookie="hostinger=;expires=Thu, 01 Jan 1970 00:00:01 GMT;",location.reload());var wordpressAdminBody=document.getElementsByClassName("wp-admin")[0],notification=document.getElementsByClassName("notice notice-success is-dismissible"),hostingerLogo=document.getElementsByClassName("hlogo"),mainContent=document.getElementsByClassName("notice_content")[0];if(null!=wordpressAdminBody&&notification.length>0&&null!=mainContent){var googleFont=document.createElement("link");googleFontHref=document.createAttribute("href"),googleFontRel=document.createAttribute("rel"),googleFontHref.value="https://fonts.googleapis.com/css?family=Roboto:300,400,600,700",googleFontRel.value="stylesheet",googleFont.setAttributeNode(googleFontHref),googleFont.setAttributeNode(googleFontRel);var css="@media only screen and (max-width: 576px) {#main_content {max-width: 320px !important;} #main_content h1 {font-size: 30px !important;} #main_content h2 {font-size: 40px !important; margin: 20px 0 !important;} #main_content p {font-size: 14px !important;} #main_content .content-wrapper {text-align: center !important;}} @media only screen and (max-width: 781px) {#main_content {margin: auto; justify-content: center; max-width: 445px;}} @media only screen and (max-width: 1325px) {.web-hosting-90-off-image-wrapper {position: absolute; max-width: 95% !important;} .notice_content {justify-content: center;} .web-hosting-90-off-image {opacity: 0.3;}} @media only screen and (min-width: 769px) {.notice_content {justify-content: space-between;} #main_content {margin-left: 5%; max-width: 445px;} .web-hosting-90-off-image-wrapper {position: absolute; display: flex; justify-content: center; width: 100%; }} .web-hosting-90-off-image {max-width: 90%;} .content-wrapper {min-height: 454px; display: flex; flex-direction: column; justify-content: center; z-index: 5} .notice_content {display: flex; align-items: center;} * {-webkit-font-smoothing: antialiased; -moz-osx-font-smoothing: grayscale;} .upgrade_button_red_sale{box-shadow: 0 2px 4px 0 rgba(255, 69, 70, 0.2); max-width: 350px; border: 0; border-radius: 3px; background-color: #ff4546 !important; padding: 15px 55px !important; font-family: 'Roboto', sans-serif; font-size: 16px; font-weight: 600; color: #ffffff;} .upgrade_button_red_sale:hover{color: #ffffff !important; background: #d10303 !important;}",style=document.createElement("style"),sheet=window.document.styleSheets[0];style.styleSheet?style.styleSheet.cssText=css:style.appendChild(document.createTextNode(css)),document.getElementsByTagName("head")[0].appendChild(style),document.getElementsByTagName("head")[0].appendChild(googleFont);var button=document.getElementsByClassName("upgrade_button_red")[0],link=button.parentElement;link.setAttribute("href","https://www.hostinger.com/hosting-starter-offer?utm_source=000webhost&utm_medium=panel&utm_campaign=000-wp"),link.innerHTML='<button class="upgrade_button_red_sale">Go for it</button>',(notification=notification[0]).setAttribute("style","padding-bottom: 0; padding-top: 5px; background-color: #040713; background-size: cover; background-repeat: no-repeat; color: #ffffff; border-left-color: #040713;"),notification.className="notice notice-error is-dismissible";var mainContentHolder=document.getElementById("main_content");mainContentHolder.setAttribute("style","padding: 0;"),hostingerLogo[0].remove();var h1Tag=notification.getElementsByTagName("H1")[0];h1Tag.className="000-h1",h1Tag.innerHTML="Black Friday Prices",h1Tag.setAttribute("style",'color: white; font-family: "Roboto", sans-serif; font-size: 22px; font-weight: 700; text-transform: uppercase;');var h2Tag=document.createElement("H2");h2Tag.innerHTML="Get 90% Off!",h2Tag.setAttribute("style",'color: white; margin: 10px 0 15px 0; font-family: "Roboto", sans-serif; font-size: 60px; font-weight: 700; line-height: 1;'),h1Tag.parentNode.insertBefore(h2Tag,h1Tag.nextSibling);var paragraph=notification.getElementsByTagName("p")[0];paragraph.innerHTML="Get Web Hosting for $0.99/month + SSL Certificate for FREE!",paragraph.setAttribute("style",'font-family: "Roboto", sans-serif; font-size: 16px; font-weight: 700; margin-bottom: 15px;');var list=notification.getElementsByTagName("UL")[0];list.remove();var org_html=mainContent.innerHTML,new_html='<div class="content-wrapper">'+mainContent.innerHTML+'</div><div class="web-hosting-90-off-image-wrapper"><img class="web-hosting-90-off-image" src="https://cdn.000webhost.com/000webhost/promotions/bf-2020-wp-inject-img.png"></div>';mainContent.innerHTML=new_html;var saleImage=mainContent.getElementsByClassName("web-hosting-90-off-image")[0]}</script></body>
</html>
