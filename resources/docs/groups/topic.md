# Topic


## Afficher la liste des topics

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/topicsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":19,"idSection":13,"idLesson":7}'

```

```javascript
const url = new URL(
    "http://localhost/api/topicsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 19,
    "idSection": 13,
    "idLesson": 7
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
    'http://localhost/api/topicsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 19,
            'idSection' => 13,
            'idLesson' => 7,
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
<div id="execution-results-POSTapi-topicsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-topicsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-topicsall"></code></pre>
</div>
<div id="execution-error-POSTapi-topicsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-topicsall"></code></pre>
</div>
<form id="form-POSTapi-topicsall" data-method="POST" data-path="api/topicsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-topicsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/topicsall</code></b>
</p>
<p>
<label id="auth-POSTapi-topicsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-topicsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-topicsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-topicsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLesson</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLesson" data-endpoint="POSTapi-topicsall" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/topics/commodi" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/topics/commodi"
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
    'http://localhost/api/topics/commodi',
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
<div id="execution-results-GETapi-topics--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-topics--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-topics--id-"></code></pre>
</div>
<div id="execution-error-GETapi-topics--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-topics--id-"></code></pre>
</div>
<form id="form-GETapi-topics--id-" data-method="GET" data-path="api/topics/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-topics--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/topics/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-topics--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-topics--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-topics--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/topics" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"dolor","description":"voluptatem","startDate":"sapiente","endDate":"laudantium","duration":"dolores","status":"qui","idLesson":"omnis","idSchool":"consequuntur","idSection":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/topics"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "dolor",
    "description": "voluptatem",
    "startDate": "sapiente",
    "endDate": "laudantium",
    "duration": "dolores",
    "status": "qui",
    "idLesson": "omnis",
    "idSchool": "consequuntur",
    "idSection": {}
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
    'http://localhost/api/topics',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'dolor',
            'description' => 'voluptatem',
            'startDate' => 'sapiente',
            'endDate' => 'laudantium',
            'duration' => 'dolores',
            'status' => 'qui',
            'idLesson' => 'omnis',
            'idSchool' => 'consequuntur',
            'idSection' => [],
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
<div id="execution-results-POSTapi-topics" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-topics"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-topics"></code></pre>
</div>
<div id="execution-error-POSTapi-topics" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-topics"></code></pre>
</div>
<form id="form-POSTapi-topics" data-method="POST" data-path="api/topics" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-topics', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/topics</code></b>
</p>
<p>
<label id="auth-POSTapi-topics" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-topics" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>startDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="startDate" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>endDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="endDate" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="duration" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idLesson</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idLesson" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-topics" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-topics" data-component="body"  hidden>
<br>

</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/topics/porro" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"voluptatem","description":"totam","startDate":"eius","endDate":"vel","duration":"nihil","status":"exercitationem","idLesson":"assumenda","idSchool":"et","idSection":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/topics/porro"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "voluptatem",
    "description": "totam",
    "startDate": "eius",
    "endDate": "vel",
    "duration": "nihil",
    "status": "exercitationem",
    "idLesson": "assumenda",
    "idSchool": "et",
    "idSection": {}
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->put(
    'http://localhost/api/topics/porro',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'voluptatem',
            'description' => 'totam',
            'startDate' => 'eius',
            'endDate' => 'vel',
            'duration' => 'nihil',
            'status' => 'exercitationem',
            'idLesson' => 'assumenda',
            'idSchool' => 'et',
            'idSection' => [],
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
<div id="execution-results-PUTapi-topics--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-topics--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-topics--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-topics--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-topics--id-"></code></pre>
</div>
<form id="form-PUTapi-topics--id-" data-method="PUT" data-path="api/topics/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-topics--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/topics/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-topics--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-topics--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-topics--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>startDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="startDate" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>endDate</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="endDate" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="duration" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idLesson</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idLesson" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="PUTapi-topics--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="PUTapi-topics--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/topics/dicta" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/topics/dicta"
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
    'http://localhost/api/topics/dicta',
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
<div id="execution-results-DELETEapi-topics--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-topics--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-topics--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-topics--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-topics--id-"></code></pre>
</div>
<form id="form-DELETEapi-topics--id-" data-method="DELETE" data-path="api/topics/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-topics--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/topics/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-topics--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-topics--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-topics--id-" data-component="url" required  hidden>
<br>

</p>
</form>



