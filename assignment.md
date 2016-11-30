
# Backend Assignment

	- Design a service to upload images to a server
	- The images should be uploaded in two or more requests one for transferring images
	another for uploading the details of the product
	- Not advisable to upload the images in the same request since the greater the payload
	more the chances of the request being dropped in slow internet connections
	
	- The APIs should roughly work this way
	  - An upload image api which saves the data in a key value store like redis
	  - The following api for uploading product details which sends the rest of the product data 
		This api should save the data in some location determined by the ID of the product in the DB
		- Use your favourite SQL DB to store the product info
	  - The uploaded images should be then resized asynchronously in 2 different file sizes 256 and 512 pixel width
	  - Resized image's data should be stored in DB
	  - Setup a cron job to delete the transferred images from REDIS
	  - Provide a product fetch API for querying stored products, this should send all the prouducts data along with the 
	  images. With the images you need to send the dimensions of the image too
	- The above example seems contrived but if you have more than one server you need access to some fast store 
	shared across the servers so that the second request which carries the product data is able to use the images 
	- Secondly the part of moving it to a location determined by ID of the product seems contrived but replace 
	the location determined by ID with location on Amazon S3 services :)
	- The other option is to ensure that your load balancer redirects both the requests to the same server. This 
	is a bit tricky to get right
	- Products will have the following details
	  - ID 
	  - Name
	  - image
	  - image_256 ( Resized images )
	  - image_512 ( Resized images )
	  - price 
	- Try to strike a balance between correctness and simplicity. If you think the whole thing is getting too complex
	it's fine to sacrifice a little correctness for simplicity in design

# Suggestions

	- Feel free to use some microframework. Don't use full fledged bloated stuff that abstracts away everything in the 
	problem statement 
	- For image resizing you can use PHP ImageMagick and PHP Imagine library
	- For filehandling you can use FlySystem
	- Feel free to discard some or all of the suggestions above 
	
	
# PHP First Timer Tips
	
	- Make sure your php installation with Apache is working
	- If you're experiencing issues here, feel free to call us
	- For the Uploading and API part, make the form input first and make sure you're 
	getting the data as you want on the server side
	- PHP has a few quirks if you feel something isn't working the way you think it should
	feel free to call us. 
	- Other than that PHP is extremely easy to get started with and has one of the best
	request state model among all languages. Basically every request starts with a clean slate
	
