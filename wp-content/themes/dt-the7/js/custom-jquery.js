/*$.noConflict();*/
	/*	$(document).ready(function() {
      alert('jkjk');
			// grab the initial top offset of the navigation 
		   	var stickyNavTop = $('.blogshare').offset().top;
		   	
		   	// our function that decides weather the navigation bar should have "fixed" css position or not.
		   	var stickyNav = function(){
			    var scrollTop = $(window).scrollTop(); // our current vertical position from the top
			         
			    // if we've scrolled more than the navigation, change its position to fixed to stick to top,
			    // otherwise change it back to relative
			    if (scrollTop > stickyNavTop) { 
			        $('.blogshare').addClass('stickyn');
			    } else {
			        $('.blogshare').removeClass('stickyn'); 
			    }
			};

			stickyNav();
			// and run it again every time you scroll
			$(window).scroll(function() {
				stickyNav();
			});
		});*/

var locations = [
  ['1035/2 , mill park street , rhodes , NSW 2138', -33.823612, 151.088104, 'address 1'],
  ['53 Birchend Close, South Croydon, CR2 7DS, UK', 51.358799, -0.092074, 'address 2'],
  ['1024, Sector Rd, Sector 67, Sahibzada Ajit Singh Nagar, Punjab 160062', 30.679648, 76.726968, 'address 3'],
  ['535 Mission Street, San Francisco, CA 94105, USA', 37.788866, -122.4003987, 'address 4'],
  ];
  
  function initialize() {
    var myOptions = {
      center: new google.maps.LatLng(30.679648, 76.726968),
      zoom: 2,
      mapTypeId: google.maps.MapTypeId.ROADMAP

    };
    var map = new google.maps.Map(document.getElementById("default"),
        myOptions);


    setMarkers(map,locations)

  }
  function setMarkers(map,locations){
      var marker, i

for (i = 0; i < locations.length; i++)
 {  
 var loan = locations[i][0]
 var lat = locations[i][1]
 var long = locations[i][2]
 var add =  locations[i][3]

 latlngset = new google.maps.LatLng(lat, long);

  var marker = new google.maps.Marker({  
          map: map, title: loan , position: latlngset  
        });
        map.setCenter(marker.getPosition())


        var content = "Loan Number: " + loan +  '</h3>' + "Address: " + add     

  var infowindow = new google.maps.InfoWindow()

google.maps.event.addListener(marker,'click', (function(marker,content,infowindow){ 
        return function() {
           infowindow.setContent(content);
           infowindow.open(map,marker);
        };
    })(marker,content,infowindow)); 

  }
  }