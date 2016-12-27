<?php
// header for Bootstrap to make the example look pretty
require_once('examples/layout/header.php');

require_once("includes/ConvertKit.class.php");
require_once('examples/config.php');

$ck = new ConvertKit($apiKey, $apiSecretKey);



/*
 * VIEW TAGS
 */

// $data = $ck->api("tag/showall");

// foreach($data as $tag){
// 	print_r($tag);
// }



/*
 * VIEW SEQUENCES
 */

//$data = $ck->api("sequence/showall");

//print_r($data);
//print_r($data->courses[0]);
//echo $data->courses[0]->name;

//$sequences = $ck->sequence();
//$response = $sequences->showall();
//print_r($response);
//
//$sequences->setSequenceId(9041);
//$response = $sequences->listSubscriptions();
//print_r($response);

/*
 * VIEW SUBSCRIBERS
 */

// $response = $ck->api("subscriber/showall");


// $subscriber = $ck->subscriber();
// $response = $subscriber->showall();
// print_r($response);
// $firstName = $response->subscribers[0]->first_name;
// $email = $response->subscribers[0]->email_address;
// $fieldsObject = $response->subscribers[0]->fields;


/*
 * ADD SUBSCRIBER TO SEQUENCE
 */



//$courseId = 9041;
//
//$subscriberData = array(
//  'email' => 'jackblist+test1@gmail.com'
//);
//
//$subscriber = $ck->subscriber();
//$request = $subscriber->addToCourse($courseId, $subscriberData);
//print_r($request);


/*
 * UPDATE SUBSCRIBER CUSTOM FIELD
 */



//$customFields = array(
//  'fields' => array(
//      'deadlinetext' => 'Jan 22 2018'
//  )
//);
//
//$response = $ck->subscriber(57252571)->update($customFields);
////echo $subscriber->id .' is id';


//print_r($response);

/*
 * VIEW SUBSCRIBER DETAILS
 */

// $response = $ck->subscriber(57252571)->view();
// print_r($response);


/*
 * REMOVE SUBSCRIBER TAG
 */


// $response = $ck->subscriber(57252571)->removeTag(133119);
// print_r($response);


/*
 * LIST TAG SUBSCRIPTIONS
 */

//$tag = $ck->tag(133119)->listSubscriptions();
//print_r($tag);


/*
 * ADD TAG TO SUBSCRIBER
 * note - email is required
 */

// $subscriberData = array(
//    'email' => 'jackblist+test1@gmail.com'
// );

// $tag = $ck->tag(133119)->addToSubscriber($subscriberData);
// print_r($tag);



/*
 * DELETE TAG FROM SUBSCRIBER
 *
 */


// $tag = $ck->tag(133119)->deleteFromSubscriber(57252571);
// print_r($tag);


/*
 * VIEW FORMS
 */

//$response = $ck->form()->showall();
//print_r($response);


/*
 * SEE FORM SUBSCRIBERS
 */

//$formId = 19579;
//
//$response = $ck->form($formId)->listSubscriptions();
//print_r($response);

/*
 * ADD WEBHOOK
 */

// $params = array(
//     "target_url" => "http://example.com/incoming",
//     "event" => array(
//         'name' => 'subscriber.tag_add',
//         'tag_id'=> 133119
//     )

// );

// $response = $ck->api("webhook/add", $params);


// $webhook = $ck->webhook();
// $response = $webhook->add($params);
// print_r($response);



/*
 * VIEW ALL CUSTOM FIELDS
 */
echo '<h2>Custom Fields</h2>';

echo '
<p>Create New Custom Field</p>
<form class="form-inline" action="examples/add_custom_field.php" method="POST">
  <div class="form-group">
    <input type="text" class="form-control" id="field_name" name="field_name" placeholder="Field name here">
  </div>

  <button type="submit" class="btn btn-default">Create New Custom Field</button>
</form>
';

echo '<table class="table">
		<thead>
			<tr>
				<td>ID</td>
				<td>Name</td>
				<td>Key</td>
				<td>Label</td>
				<td>Action</td>
			</tr>
		</thead>';
echo '<tbody>';
$response = $ck->customfield()->showall();


foreach($response->custom_fields as $customfield) {
	echo '<tr><td>'.$customfield->id .'</td>'.
	'<td>'.$customfield->name .'</td>'.
	'<td>'.$customfield->key .'</td>'.
	'<td>'.$customfield->label.'</td>'.
	'<td>'.
	'<a href="?action=edit_customfield&id='.$customfield->id.'""><i class="fa fa-pencil fa-lg" aria-hidden="true"></i></a>'.
	' <a href="?action=delete_customfield&id='.$customfield->id .'" ><i class="fa fa-trash fa-lg" aria-hidden="true"></i></a>'.
	'</td>';
	echo  '</tr>';
}
echo '</tbody></table>';
// echo '<textarea class="form-control" rows="10">
// $params = array(
// 	\'label\' => \'Test\'
// );

// $customfield = $ck->customfield();
// $response = $customfield->add($params);
// </textarea>';


print_r($response);
/*
 * ADD CUSTOM FIELD
 */

// $params = array(
// 	'label' => 'Test'
// );

// $customfield = $ck->customfield();
// $response = $customfield->add($params);

// print_r($response);



/*
 * UPDATE CUSTOM FIELD
 */

// $params = array(
// 	'label' => 'TestABC'
// );

// $customfield = $ck->customfield();
// $response = $customfield->edit(8606, $params);

// print_r($response);


/*
 * UPDATE CUSTOM FIELD
 */


// $customfield = $ck->customfield();
// $response = $customfield->delete(8606);

// print_r($response);

/*
 * CREATE NEW TAG - CK has not added this functionality yet
 */

// $params = array(
// 	'name' => 'New Tag'
// );


// $tag = $ck->tag();
// $response = $tag->add($params);

// print_r($response);

// footer for Bootstrap to make the example look pretty
require_once('examples/layout/footer.php');


