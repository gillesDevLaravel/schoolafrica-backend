# Homework Done


## Afficher la liste des HomeworkDone

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/homeworkdonesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idStudent":17,"idClasse":20,"idSchool":15,"idSection":14,"idHomework":14,"idTeacher":14,"pageItems":19,"nbreItems":12,"filter_value":"placeat"}'

```

```javascript
const url = new URL(
    "http://localhost/api/homeworkdonesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idStudent": 17,
    "idClasse": 20,
    "idSchool": 15,
    "idSection": 14,
    "idHomework": 14,
    "idTeacher": 14,
    "pageItems": 19,
    "nbreItems": 12,
    "filter_value": "placeat"
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
    'http://localhost/api/homeworkdonesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idStudent' => 17,
            'idClasse' => 20,
            'idSchool' => 15,
            'idSection' => 14,
            'idHomework' => 14,
            'idTeacher' => 14,
            'pageItems' => 19,
            'nbreItems' => 12,
            'filter_value' => 'placeat',
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
<div id="execution-results-POSTapi-homeworkdonesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-homeworkdonesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-homeworkdonesall"></code></pre>
</div>
<div id="execution-error-POSTapi-homeworkdonesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-homeworkdonesall"></code></pre>
</div>
<form id="form-POSTapi-homeworkdonesall" data-method="POST" data-path="api/homeworkdonesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-homeworkdonesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/homeworkdonesall</code></b>
</p>
<p>
<label id="auth-POSTapi-homeworkdonesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-homeworkdonesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idHomework</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idHomework" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-homeworkdonesall" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/homeworkdones/sed" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/homeworkdones/sed"
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
    'http://localhost/api/homeworkdones/sed',
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
<div id="execution-results-GETapi-homeworkdones--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-homeworkdones--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-homeworkdones--id-"></code></pre>
</div>
<div id="execution-error-GETapi-homeworkdones--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-homeworkdones--id-"></code></pre>
</div>
<form id="form-GETapi-homeworkdones--id-" data-method="GET" data-path="api/homeworkdones/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-homeworkdones--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/homeworkdones/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-homeworkdones--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-homeworkdones--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-homeworkdones--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/homeworkdones" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"description":"rerum","idStudent":"corporis","idHomework":"sed","idSchool":"eos","idSection":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/homeworkdones"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "description": "rerum",
    "idStudent": "corporis",
    "idHomework": "sed",
    "idSchool": "eos",
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
    'http://localhost/api/homeworkdones',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'description' => 'rerum',
            'idStudent' => 'corporis',
            'idHomework' => 'sed',
            'idSchool' => 'eos',
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
<div id="execution-results-POSTapi-homeworkdones" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-homeworkdones"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-homeworkdones"></code></pre>
</div>
<div id="execution-error-POSTapi-homeworkdones" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-homeworkdones"></code></pre>
</div>
<form id="form-POSTapi-homeworkdones" data-method="POST" data-path="api/homeworkdones" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-homeworkdones', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/homeworkdones</code></b>
</p>
<p>
<label id="auth-POSTapi-homeworkdones" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-homeworkdones" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-homeworkdones" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idStudent" data-endpoint="POSTapi-homeworkdones" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idHomework</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idHomework" data-endpoint="POSTapi-homeworkdones" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-homeworkdones" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-homeworkdones" data-component="body"  hidden>
<br>

</p>

</form>


## api/homeworkdones/download

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/homeworkdones/download" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idStudent":10,"idHomework":1,"idHomeworkDone":19}'

```

```javascript
const url = new URL(
    "http://localhost/api/homeworkdones/download"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idStudent": 10,
    "idHomework": 1,
    "idHomeworkDone": 19
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
    'http://localhost/api/homeworkdones/download',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idStudent' => 10,
            'idHomework' => 1,
            'idHomeworkDone' => 19,
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
<div id="execution-results-POSTapi-homeworkdones-download" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-homeworkdones-download"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-homeworkdones-download"></code></pre>
</div>
<div id="execution-error-POSTapi-homeworkdones-download" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-homeworkdones-download"></code></pre>
</div>
<form id="form-POSTapi-homeworkdones-download" data-method="POST" data-path="api/homeworkdones/download" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-homeworkdones-download', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/homeworkdones/download</code></b>
</p>
<p>
<label id="auth-POSTapi-homeworkdones-download" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-homeworkdones-download" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-homeworkdones-download" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idHomework</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idHomework" data-endpoint="POSTapi-homeworkdones-download" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idHomeworkDone</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idHomeworkDone" data-endpoint="POSTapi-homeworkdones-download" data-component="body"  hidden>
<br>

</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/homeworkdones/qui" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/homeworkdones/qui"
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
    'http://localhost/api/homeworkdones/qui',
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
<div id="execution-results-PUTapi-homeworkdones--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-homeworkdones--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-homeworkdones--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-homeworkdones--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-homeworkdones--id-"></code></pre>
</div>
<form id="form-PUTapi-homeworkdones--id-" data-method="PUT" data-path="api/homeworkdones/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-homeworkdones--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/homeworkdones/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-homeworkdones--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-homeworkdones--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-homeworkdones--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/homeworkdones/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/homeworkdones/et"
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
    'http://localhost/api/homeworkdones/et',
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
<div id="execution-results-DELETEapi-homeworkdones--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-homeworkdones--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-homeworkdones--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-homeworkdones--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-homeworkdones--id-"></code></pre>
</div>
<form id="form-DELETEapi-homeworkdones--id-" data-method="DELETE" data-path="api/homeworkdones/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-homeworkdones--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/homeworkdones/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-homeworkdones--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-homeworkdones--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-homeworkdones--id-" data-component="url" required  hidden>
<br>

</p>
</form>



