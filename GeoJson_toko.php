<?php

//Connect to MySQL database
$connection = mysqli_connect("localhost", "root", "", "data_sig");

//Spatial query: convert GEOMETRY to GeoJSON + the attributes
$sql="select id,nama,ST_asGeoJson(SHAPE) geom from toko";
$result = mysqli_query($connection,$sql);

//Decoding and restructuring: 

$i=0;
$json = array();

/*Read the query results:
membuat iterasi untuk membaca record dan mengubahnya menjadi obyek, 
kemudian ditata ulang mengikuti format Feature: properties, geometry */

while($row = mysqli_fetch_array($result)){
    
    //convert the attributes into object
    $attributes = array("OGR_FID"=>$row['id'],"NAME"=>$row['nama']); // 
    
    //decode the GeoJson
    $geom = json_decode($row['geom'], true); 
    
    //put all together in Geojson Feature formatted structure
    $data = array("type"=>"Feature", "id"=>$row['id'], "properties"=> $attributes, "geometry"=>$geom);        
    $json[$i]=$data;
    $i++;   
}

//put all together in Geojson FeatureCollection formatted structure
$jsons = array("type"=>"FeatureCollection","features"=>$json);

//Encoding: encode the restructured data into Json
echo json_encode($jsons);

mysqli_close($connection);

?>
