## Export content

The API works as a mappiamo module but doesnt generate view. 
It returns raw data only in JSON format.
  
###### Examples:

Searhing with **geo coordinates**: 
> index.php?module=api&task=search&lat=xx.xxxxx&lng=xx.xxxx&radius=50 
The example will show data from a circle with radius of 50km, from the position of lat and lng.
  
**Category filter**: 
> index.php?module=api&task=search&lat=xx.xxxxx&lng=xx.xxxx&radius=50&cat=20  
and
> index.php?module=api&task=search&lat=xx.xxxxx&lng=xx.xxxx&radius=50&cat=category-name 
The examples are similar to the previous, but there is a filter that will show the result set from the selected category only (id or category-name can be given).

**All data from a category**: 
> index.php?module=api&task=category&object=20 or &object=category-name

**One content** (with given ID): 
> index.php?module=api&task=content&object=22
  
