# Task


## Display a listing of the resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/tasksall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":10,"idSection":18,"idUser":5,"pageItems":9,"nbreItems":19,"filter_value":{},"filter_status":{},"filter_priority":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/tasksall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 10,
    "idSection": 18,
    "idUser": 5,
    "pageItems": 9,
    "nbreItems": 19,
    "filter_value": {},
    "filter_status": {},
    "filter_priority": {}
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/tasksall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 10,
            'idSection' => 18,
            'idUser' => 5,
            'pageItems' => 9,
            'nbreItems' => 19,
            'filter_value' => [],
            'filter_status' => [],
            'filter_priority' => [],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-tasksall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-tasksall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-tasksall"></code></pre>
</div>
<div id="execution-error-POSTapi-tasksall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-tasksall"></code></pre>
</div>
<form id="form-POSTapi-tasksall" data-method="POST" data-path="api/tasksall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-tasksall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/tasksall</code></b>
</p>
<p>
<label id="auth-POSTapi-tasksall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-tasksall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_status" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_priority</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_priority" data-endpoint="POSTapi-tasksall" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/tasks/quis" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/tasks/quis"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->get(
    'http://localhost/api/tasks/quis',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-GETapi-tasks--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-tasks--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-tasks--id-"></code></pre>
</div>
<div id="execution-error-GETapi-tasks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-tasks--id-"></code></pre>
</div>
<form id="form-GETapi-tasks--id-" data-method="GET" data-path="api/tasks/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-tasks--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/tasks/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-tasks--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-tasks--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-tasks--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/tasks" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"tasks":[{"name":"quo","due_date":"minus","priority":"ut","status":"sapiente","duree_mise":8,"estimation":11,"observation":"aut","idProject":1,"idUser":3,"idSchool":4,"idSection":6}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/tasks"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "tasks": [
        {
            "name": "quo",
            "due_date": "minus",
            "priority": "ut",
            "status": "sapiente",
            "duree_mise": 8,
            "estimation": 11,
            "observation": "aut",
            "idProject": 1,
            "idUser": 3,
            "idSchool": 4,
            "idSection": 6
        }
    ]
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/tasks',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'tasks' => [
                [
                    'name' => 'quo',
                    'due_date' => 'minus',
                    'priority' => 'ut',
                    'status' => 'sapiente',
                    'duree_mise' => 8,
                    'estimation' => 11,
                    'observation' => 'aut',
                    'idProject' => 1,
                    'idUser' => 3,
                    'idSchool' => 4,
                    'idSection' => 6,
                ],
            ],
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-POSTapi-tasks" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-tasks"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-tasks"></code></pre>
</div>
<div id="execution-error-POSTapi-tasks" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-tasks"></code></pre>
</div>
<form id="form-POSTapi-tasks" data-method="POST" data-path="api/tasks" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-tasks', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/tasks</code></b>
</p>
<p>
<label id="auth-POSTapi-tasks" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-tasks" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>tasks</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>tasks[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="tasks.0.name" data-endpoint="POSTapi-tasks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>tasks[].due_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="tasks.0.due_date" data-endpoint="POSTapi-tasks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>tasks[].priority</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="tasks.0.priority" data-endpoint="POSTapi-tasks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>tasks[].status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="tasks.0.status" data-endpoint="POSTapi-tasks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>tasks[].duree_mise</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="tasks.0.duree_mise" data-endpoint="POSTapi-tasks" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>tasks[].estimation</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="tasks.0.estimation" data-endpoint="POSTapi-tasks" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>tasks[].observation</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="tasks.0.observation" data-endpoint="POSTapi-tasks" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>tasks[].idProject</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="tasks.0.idProject" data-endpoint="POSTapi-tasks" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>tasks[].idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="tasks.0.idUser" data-endpoint="POSTapi-tasks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>tasks[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="tasks.0.idSchool" data-endpoint="POSTapi-tasks" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>tasks[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="tasks.0.idSection" data-endpoint="POSTapi-tasks" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/tasks/velit" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/tasks/velit"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "PUT",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/tasks/velit',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-PUTapi-tasks--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-tasks--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-tasks--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-tasks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-tasks--id-"></code></pre>
</div>
<form id="form-PUTapi-tasks--id-" data-method="PUT" data-path="api/tasks/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-tasks--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/tasks/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-tasks--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-tasks--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-tasks--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/tasks/at" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/tasks/at"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "DELETE",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->delete(
    'http://localhost/api/tasks/at',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (401):

```json
{
    "message": "Unauthenticated."
}
```
<div id="execution-results-DELETEapi-tasks--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-tasks--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-tasks--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-tasks--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-tasks--id-"></code></pre>
</div>
<form id="form-DELETEapi-tasks--id-" data-method="DELETE" data-path="api/tasks/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-tasks--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/tasks/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-tasks--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-tasks--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-tasks--id-" data-component="url" required  hidden>
<br>

</p>
</form>



