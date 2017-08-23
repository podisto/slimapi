<?php
// Routes

header('Access-Control-Allow-Origin: *');

$app->get('/api', function ($request, $response, $args) {
    echo "Hello API";
});

// get all users
$app->get('/api/users', function ($request, $response, $args) {
    $sth = $this->db->prepare("SELECT * FROM user ORDER BY id");
    $sth->execute();
    $users = $sth->fetchAll();
    //echo json_encode(['status' => 'success', 'data' => $users]);
    return $this->response->withJson($users);
});

$app->post('/api/user', function($request, $response) {
	$json = $request->getBody();
	$input = json_decode($json, true);
	$sql = "INSERT INTO user (firstname, lastname) VALUES (:firstname, :lastname)";
	$sth = $this->db->prepare($sql);
	$sth->bindParam('firstname', $input['firstname']);
	$sth->bindParam('lastname', $input['lastname']);
	$sth->execute();

	$input['id'] = $this->db->lastInsertId();

	return $this->response->withJson($input);
});
