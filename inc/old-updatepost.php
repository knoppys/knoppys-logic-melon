<?php

 
function melon_vacancies() {

//Get the XML file
	//Use this as a test file
	//$file = file_get_contents('http://185.77.83.90/~greenfield/wp-content/plugins/knoppys-logic-melon/inc/file.xml');
	
	//Use this as the live file
	$file = file_get_contents('http://media.logicmelon.co.uk/CacheUploads/greenfieldIT/LogicMelon.xml');

	$vacancies = new SimpleXMLElement($file);
	
	foreach ($vacancies->Vacancy as $vacancy) {

		$args = array(
			'post_type' => 'vacancy',
			'meta_key' => 'Reference',
			'meta_value' => (string)$vacancy->Reference,
			'post_status' => 'publish',
		);
		$vacancyCheck = get_posts($args);	

		if ($vacancyCheck) {

			//echo (string)$vacancy->Reference.': this post has been found<br>';
			

			//Get the existing ID
			$existingPostId = $vacancyCheck[0]->ID;
			
			//Insert the post basics
			$basics = array(
			'ID' => $existingPostId,					
			'post_title' => (string)$vacancy->Title,
			'post_content' => (string)$vacancy->JobDescription,
			'post_date' => (string)$vacancy->CreatedDate,
			'post_type' => 'vacancy',					
			);	
			$updatecheck = wp_update_post($basics);
			
				//Check to see if the upadte has worked.
				if ($updatecheck) {
					//echo (string)$vacancy->Reference . ' this post has been updated <br><br>';
				}

			//Update the post meta
			$IsHidden = strtolower((string)$vacancy->IsHidden);
			$IsTraining = strtolower((string)$vacancy->TrainingJobs);

			$meta = array(
			'Reference' => (string)$vacancy->Reference,			
			'Individual' => (string)$vacancy->Individual,
			'ContactEmail' => (string)$vacancy->ContactEmail,
			'Location' => (string)$vacancy->Location,
			'Salary' => (string)$vacancy->Salary,		
			'IsHidden' => $IsHidden,
			'Training' => $IsTraining		
			);
				foreach ($meta as $key => $value) {
					$update = update_post_meta($existingPostId, $key, $value);
					if ($update) {
						//echo $key . ' Has been updated to '. $value . '<br>';
					}
													
				}

			//Update JobType Taxonomy
			wp_set_object_terms($existingPostId, (string)$vacancy->JobType, 'JobType');
							
			//Update Industry Taxonomy			
			wp_set_object_terms($existingPostId, (string)$vacancy->Industry, 'Industry');

		
		} else {
			//echo (string)$vacancy->Reference.': this post has not been found<br>';
			//If it doesnt exist then create it.

			//Insert the post basics
			$basics = array(					
			'post_title' => (string)$vacancy->Title,
			'post_content' => (string)$vacancy->JobDescription,
			//'post_date' => (string)$vacancy->CreatedDate,
			'post_type' => 'vacancy',	
			'post_status' => 'publish'				
			);	
			$new_post = wp_insert_post($basics, true);
			
			//Check to see if the upadte has worked.
			if ($new_post) {
				//echo 'Job Ref Main'. (string)$vacancy->Reference . ': this post has been created <br><br>';
			}

			//Update the post meta
			$IsHidden = strtolower((string)$vacancy->IsHidden);
			$IsTraining = strtolower((string)$vacancy->TrainingJobs);
			$meta = array(
			'Reference' => (string)$vacancy->Reference,			
			'Individual' => (string)$vacancy->Individual,
			'ContactEmail' => (string)$vacancy->ContactEmail,
			'Location' => (string)$vacancy->Location,
			'Salary' => (string)$vacancy->Salary,		
			'IsHidden' => $IsHidden,
			'Training' => $IsTraining		
			);
			foreach ($meta as $key => $value) {
				$update = update_post_meta($new_post, $key, $value);												
			}

			//Update JobType Taxonomy
			wp_set_object_terms($new_post, (string)$vacancy->JobType, 'JobType');
							
			//Update Industry Taxonomy			
			wp_set_object_terms($new_post, (string)$vacancy->Industry, 'Industry');
			
		}	
	}
}

function vacancies_clean_up() {

//Get the XML file
	//Use this as a test file
	//$file = file_get_contents('http://185.77.83.90/~greenfield/wp-content/plugins/knoppys-logic-melon/inc/file.xml');
	
	//Use this as the live file
	$file = file_get_contents('http://media.logicmelon.co.uk/CacheUploads/greenfieldIT/LogicMelon.xml');

	$remoteVacancies = new SimpleXMLElement($file);

	//Create an array of job refrences
	$remotearray = array();
	foreach ($remoteVacancies->Vacancy as $vacancy) {
		$remotearray[] = (string)$vacancy->Reference;
	}
	
	//Get the job posts
	$args = array(
		'post_type' => 'vacancy',
		'posts_per_page' => -1		
	);
	$localVacancies = get_posts($args);	

	foreach ($localVacancies as $localVacancy) { $jobRef = get_post_meta($localVacancy->ID, 'Reference', true);
		
		if(in_array($jobRef, $remotearray)){		
		} else {
			wp_delete_post( $localVacancy->ID, true );
		}
		
	}
}

function status_report(){

	//Use this as the live file
	$file = file_get_contents('http://media.logicmelon.co.uk/CacheUploads/greenfieldIT/LogicMelon.xml');

	$remoteVacancies = new SimpleXMLElement($file);

	//Create an array of job refrences
	$remotearray = array();
	foreach ($remoteVacancies->Vacancy as $vacancy) {
		$remotearray[] = (string)$vacancy->Reference;
	}

	ob_start();
	?>

	<div class="wrapper">
	<h1>XML > Site Status Page</h1>
	<p>This page will show you the list of Job (by ref) in the Logic Melon XML Feed and the jobs status within the site.</p>
	<style type="text/css">
		table.xmlstatus td {border: 1px solid;width: 300px;}
		table.xmlstatus thead td {font-weight: bold;}
	</style>
	<table class="xmlstatus">
		<thead>
			<tr>
				<td>XML Job Ref</td>
				<td>Website Vacancy Status</td>
			</tr>
		</thead>
		<tbody>
			<?php foreach ($remotearray as $ref) { ?>
				
				<tr>
					<td><?php echo $ref; ?></td>
					<td>						
						<?php 
						$args = array(
							'post_type' => 'vacancy',
							'posts_per_page' => -1,
							'meta_key' => 'Reference',
							'meta_value' => $ref

						);
						$localVacancies = get_posts($args);	
						foreach ($localVacancies as $vac) {
							echo 'In Site';
						}
						?>
					</td>
				</tr>

			<?php }	?>
		</tbody>
	</table>

	</div>
	<?php
	$content = ob_get_clean();
	return $content;

}
