Furry-dangerzone
========================

This is a Symfony2 application that manages geographic locations and information about them and serving it all publically as GeoJson objects.

1) Setup
--------------------------------

See the symfony2 doc: url

2) The pubic interface
--------------------------------

### To get all the locations stored

    http://yoursite/json
    
This will return a GeoJson object.

### To get the information about a location

For example a location with the id: 1

    http://yoursite/location/1.json
    
This will return a GeoJson object.

### To add a new location

    http://yoursite/location/add

### To add new location information

    http://yoursite/link/add/{id}