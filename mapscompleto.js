function InicialMap(){
	$(document).ready(function(){
       var lstIndexGuardar = [];
        var lstPuntosArray = $("#lstPuntos");
        var btnGuardar = $("#btnGuardar");
        var lstMarkers = []; 
        function markerCoords(markerobject){
			
			google.maps.event.addListener(markerobject, 'dragend', function(evt){
          
				if (strAccion != null) {

					var Latitud = evt.latLng.lat();
					var Longitud = evt.latLng.lng();
					var latlng = {lat: Latitud, lng: Longitud};
					strLatitud = Latitud; 
					strLongit = Longitud;
					geocoder.geocode({'location': latlng}, function(results, status) {
						if (status === 'OK') {
						if (results[1]) {
							
							strDirreccion = results[0].formatted_address;
							txtConsultarPunto.val(strDirreccion);
							
						} else {
							window.alert('No results found');
						}
						} else {
						window.alert('Geocoder failed due to: ' + status);
						}
					});
				}
			});
			
		}

     
        /*Iniciar Mapa*/
        function IniciarMapa(){
                var Medellin = new google.maps.LatLng(6.2548511,-75.5663697);
                var mapOptions = {
                zoom: 12,
                center: Medellin
            };

            // Calculate Height
            var el = document.getElementById('map-1'),
                doc_height =
                $(document).height() - 10 -
                $(".main-content > .user-info-navbar").outerHeight() -
                $(".main-content > .page-title").outerHeight() -
                $(".google-map-env .map-toolbar").outerHeight();

            // Adjust map height to fit the document contianer
            el.style.height = doc_height + 'px';

            map = new google.maps.Map(el, mapOptions);

            /*var marker = new google.maps.Marker({
                position: new google.maps.LatLng(6.2548511,-75.5663697),
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP
            });
            markerCoords(marker);*/

        };

     
        
    function addPunto(nombre,informacion, id){
        
        var li = '<li id="'+id+'" class=" ">';
        li = li + '<a>';
        li = li + nombre+'(' + informacion  + ')'+'</a> ';
        li = li + '</li>';
        console.log(li);

        lstPuntosArray.append(li);
        
    }

    function exitePuntoLista (indexActual) {
        var existe = false;
        $.each(lstIndexGuardar,function(index, value){
            if (indexActual == value){
                existe = true;
            }
        });
        
        return existe;
    }

	function consultarDonaciones(){
            LimpiarMapa();
            
            var starCountRef = firebase.database().ref('donacion').limitToFirst(200);
			starCountRef.once('value').then( function(snapshot) {
			
				$.each(snapshot.val(),function(index, value){
                        console.log(value.longitud);
                        console.log(value.latitud);
                  
                        var marker = new google.maps.Marker({
                            position: new google.maps.LatLng(value.latitud,value.longitud),
                            map: map,
                            icon:'http://maps.google.com/mapfiles/kml/pal2/icon26.png',
                            animation: google.maps.Animation.DROP
    
                        });
    
                        lstMarkers.push(marker);
                        marker.addListener('click', function() {
                            
                            if(!exitePuntoLista(index)){
                                var image = 'http://maps.google.com/mapfiles/kml/pal4/icon38.png';
                                marker.setIcon(image);
                                addPunto(value.nombre, value.informacion, index);
                                lstIndexGuardar.push(index);
                            }else{
                                var image = 'http://maps.google.com/mapfiles/kml/pal2/icon26.png';
                                marker.setIcon(image);
                                var i = lstIndexGuardar.indexOf(index);
                                if(i != -1) {
                                    lstIndexGuardar.splice(i, 1);
                                }
                                $("#"+index).remove();
                            }
                            
                        });
    
                        markerCoords(marker);
                    
                });
			})
        }

        btnGuardar.on("click",function(){
            if(lstIndexGuardar.length <= 0){
                swal("Alerta", "Seleccione almenos un punto");
            }else{
                swal({
                    title: "Guardar",
                    text: "Ingrese el nombre de la ruta:",
                    type: "input",
                    showCancelButton: true,
                    closeOnConfirm: false,
                    inputPlaceholder: "Guardar"
                  }, function (inputValue) {
                    if (inputValue === false) return false;
                    if (inputValue === "") {
                      swal.showInputError("es necesario un nombre");
                      return false
                    }else{
                        objRuta = {nombre: inputValue};
                        var newLugarKey = firebase.database().ref().child('ruta').push(objRuta).key;
                        objRuta['key'] = newLugarKey;
                        $.each(lstIndexGuardar, function(index, value){
                            firebase.database().ref().child('ruta').child(newLugarKey).child('puntos').push(value).key;
                            firebase.database().ref().child('donacion').child(value).child('ruta').set(newLugarKey).key;
                            firebase.database().ref().child('donacion').child(value).child('estado').set('en_camino').key;
                            
                        });
                        lstIndexGuardar = [] ;
                        lstPuntosArray.html("");
                        consultarDonaciones();
                        swal("Correcto!", "se guardo correctamente la ruta: " + inputValue, "success");
                    }
                   
                  });
            }
        });
       

        function LimpiarMapa() {
            for (var i = 0; i < lstMarkers.length; i++) {
                lstMarkers[i].setMap(null);
            }
            lstMarkers = [];
        }

        IniciarMapa();
        consultarDonaciones();

        
	
	});
}
