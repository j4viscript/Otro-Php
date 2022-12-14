<?php 
	include_once 'config.php';
	if (isset($_POST["action"])) {
		if(isset($_POST["super_token"]) && $_POST["super_token"] == $_SESSION["super_token"]) {
			switch($_POST['action'])
			{
				case 'create':
	
					$name = strip_tags($_POST['name']);
					$slug = strip_tags($_POST['slug']);
					$description = strip_tags($_POST['description']);
					$features = strip_tags($_POST['features']);
					$brand_id = strip_tags($_POST['brand_id']); 
	
					$productsController = new ProductsController();
					$productsController->createProduct($name,$slug,$description,$features,$brand_id);
				break;
	
				case 'update':
	
					$name = strip_tags($_POST['name']);
					$slug = strip_tags($_POST['slug']);
					$description = strip_tags($_POST['description']);
					$features = strip_tags($_POST['features']);
					$brand_id = strip_tags($_POST['brand_id']); 
	
					$id = strip_tags($_POST['id']); 
	
					$productsController = new ProductsController();
					$productsController->updateProduct($name,$slug,$description,$features,$brand_id,$id);
				break;
	
				case 'delete':
					
					$id = strip_tags($_POST['id']);
	
					$productsController = new ProductsController();
	
					echo json_encode( $productsController->remove($id) );
	
				break;
			}
		}
	}

	Class ProductsController
	{

		public function getProducts()
		{

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Bearer '.$_SESSION['token']
			  ),
			));

			$response = curl_exec($curl); 
			curl_close($curl);
			$response = json_decode($response);

			if (isset($response->code) && $response->code>0) {
				
				return $response->data;
				
			}else{
				return array();
			}

		}

		public function getProductBySlug($slug)
		{

			$curl = curl_init(); 

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/slug/'.$slug,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'GET',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Bearer '.$_SESSION['token']
			  ),
			));

			$response = curl_exec($curl); 
			curl_close($curl);
			$response = json_decode($response); 

			if (isset($response->code) && $response->code>0) {
				
				return $response->data;
				
			}else{
				return array();
			}

		}

		public function createProduct($name,$slug,$description,$features,$brand_id)
		{
			$curl = curl_init();

			#var_dump($_FILES['cover']['tmp_name']);

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'POST',
			  CURLOPT_POSTFIELDS => array(
			  	'name' => $name,
			  	'slug' => $slug,
			  	'description' => $description,
			  	'brand_id' => $brand_id,
			  	'cover'=> new CURLFILE($_FILES['cover']['tmp_name'])
			  ),
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Bearer '.$_SESSION['token']
			  ),
			));

			$response = curl_exec($curl); 
			curl_close($curl);
			$response = json_decode($response); 

			if (isset($response->code) && $response->code > 0) { 

				header("Location:../products?success");

			}else{

				header("Location:../products?error");
			}
		}

		public function updateProduct($name,$slug,$description,$features,$brand_id,$id)
		{
			$curl = curl_init(); 

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products',
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'PUT',
			  CURLOPT_POSTFIELDS => 'name='.$name.'&slug='.$slug.'&description='.$description.'&features='.$features.'&brand_id='.$brand_id.'&id='.$id,
			  CURLOPT_HTTPHEADER => array(
			   'Authorization: Bearer '.$_SESSION['token'],
			    'Content-Type: application/x-www-form-urlencoded'
			  ),
			));

			$response = curl_exec($curl); 
			curl_close($curl);
			$response = json_decode($response); 

			if (isset($response->code) && $response->code > 0) { 

				header("Location:../products?success");

			}else{

				header("Location:../products?error");
			}
		}

		public function remove($id)
		{

			$curl = curl_init();

			curl_setopt_array($curl, array(
			  CURLOPT_URL => 'https://crud.jonathansoto.mx/api/products/'.$id,
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => '',
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_FOLLOWLOCATION => true,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => 'DELETE',
			  CURLOPT_HTTPHEADER => array(
			    'Authorization: Bearer '.$_SESSION['token']
			  ),
			));

			$response = curl_exec($curl); 
			curl_close($curl);
			$response = json_decode($response);  

			if (isset($response->code) && $response->code > 0) { 

				return true;

			}else{

				return false;
			}
		}

	}



?>