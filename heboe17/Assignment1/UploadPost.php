<?php
	require 'Login_required.php';
?>

<?php	
	$post_title = filter_input(INPUT_POST, "post_title", FILTER_SANITIZE_STRING);
	$post_description=filter_input(INPUT_POST, "post_description", FILTER_SANITIZE_STRING);
	
	$post_title = htmlentities($post_title);
	$post_description = htmlentities($post_description);
	
	$regex_Title = "/^(\w|\s){1,50}$/";
	$regex_Description = "/^([\x20-\x7D]|\s){1,500}+$/";
	
	$title_match = preg_match($regex_Title, $post_title);
	$description_match = preg_match($regex_Description, $post_description);
	
	if(isset($_POST['submit'])){
		$name = $_FILES['image']['name'];
		$target_dir = "upload/";
		$target_file = $target_dir . basename($_FILES["image"]["name"]);
		
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		
		$extensions_arr = array("jpg","jpeg","png","gif");
		
		if( in_array($imageFileType,$extensions_arr) ){
			$image_base64 = base64_encode(file_get_contents($_FILES['image']['tmp_name']) );
			$image = 'data:image/'.$imageFileType.';base64,'.$image_base64;
			
			if($title_match && $description_match){
				uploadPost($post_title, $post_description, $image);
				header("Location:posts.php");
			}	
		}
	}
?>

<html>    
	<head>        
		<title>HCHB's Exercise</title>
			<!-- <meta name="viewport" content="width=device-width, initial-scale=1.0"> --> 
			<!-- <link rel="shortcut icon" type="image/png" href="/favicon.png"/> --> 
			<!-- <body background="bgimage.jpg">  -->
			<!-- <body bgcolor="#E6E6FA">  -->
			<script src="UploadPost.js"></script>
			<link rel="stylesheet" type="text/css" href="GeneralLook.css">
	</head>
	<body> 
		<?php
			include 'NavigationBar.php';
		?>
		<div class='main'>
			<?php
				include 'GeneralContentLeft.php';
			?>
			
			<div class="content">
				<form action="UploadPost.php" method="POST" onsubmit="return checkFields()" enctype='multipart/form-data'>
					<label for="post_title">Title</label>
					<br>
					<?php
					if(isset($_POST["post_title"])){
						if($title_match){
							echo '<input type="text" name="post_title" id="post_title" value='.$post_title.' />';
						}else{
							echo '<input type="text" name="post_title" id="post_title" style="border:2px solid red;"/> ';
						}
					} else {
							echo '<input type="text" name="post_title" id="post_title"/>';
					}
					?>
					<br>
					<br>
					
					<label for="post_description">Description</label>
					<br>
					<?php
					if(isset($_POST["post_description"])){
						if($description_match){
							echo '<textarea name="post_description" id="post_description">'.$post_description.'</textarea>';
						}else{
							echo '<textarea name="post_description" id="post_description" style="border:2px solid red;"></textarea> ';
						}
					} else {
							echo '<textarea name="post_description" id="post_description"></textarea>';
					}
					?>
					<br>
					<br>
					
					<label for="image">Choose a picture</label>
					<br>
					<input type='file' name='image' />
					<br>
					<br>
					
					<input type="submit" name="submit" id="submit" value='Post'/> 				
				</form>
			</div>
			
			<?php
				include 'GeneralContentRight.php';
			?>
		</div>
	</body>
</html>


<?php

function uploadPost($header, $description, $image){
		require_once 'db_config.php';
		
		try {
			$conn = new PDO("mysql:host=$servername;dbname=$dbname",
			$username,
			$password,
			array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
	
			$stmt = $conn->prepare("INSERT INTO post(header, description, picture) VALUES(:header, :description, :image);");
			
			$stmt->bindParam(':header',$header);
			$stmt->bindParam(':description',$description);
			$stmt->bindParam(':image',$image);
			
			$stmt->execute();

			
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
			
		$conn = null;		
}

?>