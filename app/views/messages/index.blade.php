@section('title', 'Your Inbox')

@section('head')

	{{ HTML::script('js/angular/angular.min.js') }}
	{{ HTML::script('js/angular/angularBooter.js') }}

	<script>
		messageApp = new AngularBooter('messageApp');
    </script>

@stop

@section('content')

	<div id="messages" ng-cloak ng-app="messageApp" ng-controller="messageController" >

		<div class="row">

			<div class="col-md-3">

				<div id="threads" ng-show="threads">
					<article ng-click="getThread(thread.id)" class="message-excerpt" ng-repeat="thread in threads">
						<p><small>@{{thread.created_at}}</small></p>
						<p>From: <strong>@{{thread.sender.first_name}}</strong></p>
						<p>@{{thread.content}}</p>
						<hr>
					</article>
				</div>

				<div class="alert alert-info" ng-hide="threads">No Messages</div>

			</div>

			<div class="col-md-9">
				
				<div class="message-view" ng-show="messages">
					
					<article class="message" ng-repeat="message in messages">
						<p><strong>@{{message.sender.first_name}} @{{message.sender.last_name}}</strong></p>
						<p>@{{message.content}}</p>
					</article>

					<div ng-show="errors" class="alert alert-danger">
						<li ng-repeat="error in errors">@{{error[0]}}</li>
					</div>

					<div ng-show="messages">
						<h4>Reply</h4>
						<form method="POST" name="reply" ng-submit="sendMessage(content, recipient, threadId)">
							<textarea name="content" ng-model="content" class="form-control"></textarea>
							<button type="submit" class="btn btn-success">Reply</button>
						</form>
					</div>

				</div>

				<div class="alert alert-info" ng-hide="messages">Click on a message on the left to view the thread</div>

			</div>

		</div>

	</div>

@stop

@section('scripts')

	<script>
		messageApp.controllers.messageController = ['$scope', '$http', function($scope, $http) {
			$scope.threads = {{json_encode($threads->toArray())}};
			$scope.messages = [];
			$scope.recipient = 0;
			$scope.threadId = 0;
			$scope.errors = '';

			$scope.sendMessage = function(content, recipient, threadId) {
				$http.post('api/messages/send/' + recipient , {
					'content' : content,
					'thread_id' : threadId
				}).then(function(response) {

					$scope.content = '';

					// Store the response in a variable
					var $response = response.data;

					// If there is an error
					if($response.errors) {

						// Add the error to the scope so that it will display above
						$scope.errors = $response.errors;
					}

					// If it was successful
					if($response.message) {

						// Clear the errors
						$scope.errors = '';

						// Add the returned message to the scope
						$scope.messages.push($response.message[0]);
					}
				}, function(response) {
					console.log('failed');
				});
			}

			// When a thread is clicked on this method takes the thread ID and uses the getThreadFromApi function to retrieve all of the messages children
			$scope.getThread = function(id) {

				// Store the sender_id of the message
				$scope.setRecipient(id);

				// Stores the current thread id so that when the user replies we can pass this id to the apiSend method and keep the reply nested in the thread
				$scope.threadId = id;

				$scope.messages = $scope.getThreadFromApi(id).then(function(response, status) {
					$scope.messages = response.data;
				});
				
			}

			// Method to find the recipient for the mail. It finds the message parent i.e. the first one in the thread and compares the logged in users id with the sender id and recipient id. 

			$scope.setRecipient = function(id) {
				$http.get('api/findMessageRecipient/' + id).then(function(response) {
					$scope.recipient = response.data;
				});
			}

			// Method to return all children of the parent message and display the thread in the right panel
			$scope.getThreadFromApi = function(id) {
				return $http.get('api/thread/' + id);
			}
		}];

		messageApp.boot();
	</script>

@stop