# Parental Monitoring


## Lister les contrôles parentaux

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/parentalmonitoringsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":6,"idSection":6,"idClasse":19,"idStudent":10}'

```

```javascript
const url = new URL(
    "http://localhost/api/parentalmonitoringsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 6,
    "idSection": 6,
    "idClasse": 19,
    "idStudent": 10
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
    'http://localhost/api/parentalmonitoringsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 6,
            'idSection' => 6,
            'idClasse' => 19,
            'idStudent' => 10,
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
<div id="execution-results-POSTapi-parentalmonitoringsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-parentalmonitoringsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-parentalmonitoringsall"></code></pre>
</div>
<div id="execution-error-POSTapi-parentalmonitoringsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-parentalmonitoringsall"></code></pre>
</div>
<form id="form-POSTapi-parentalmonitoringsall" data-method="POST" data-path="api/parentalmonitoringsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-parentalmonitoringsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/parentalmonitoringsall</code></b>
</p>
<p>
<label id="auth-POSTapi-parentalmonitoringsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-parentalmonitoringsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-parentalmonitoringsall" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-parentalmonitoringsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClasse" data-endpoint="POSTapi-parentalmonitoringsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idStudent" data-endpoint="POSTapi-parentalmonitoringsall" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/parentalmonitorings/quia" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/parentalmonitorings/quia"
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
    'http://localhost/api/parentalmonitorings/quia',
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
<div id="execution-results-GETapi-parentalmonitorings--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-parentalmonitorings--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-parentalmonitorings--id-"></code></pre>
</div>
<div id="execution-error-GETapi-parentalmonitorings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-parentalmonitorings--id-"></code></pre>
</div>
<form id="form-GETapi-parentalmonitorings--id-" data-method="GET" data-path="api/parentalmonitorings/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-parentalmonitorings--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/parentalmonitorings/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-parentalmonitorings--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-parentalmonitorings--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-parentalmonitorings--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/parentalmonitorings" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"culpa","type":"quo","comment":"et","answer":"beatae","idParent":"ut","idStudent":"sit","idClasse":"illum","idSchool":"hic","idSection":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/parentalmonitorings"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "culpa",
    "type": "quo",
    "comment": "et",
    "answer": "beatae",
    "idParent": "ut",
    "idStudent": "sit",
    "idClasse": "illum",
    "idSchool": "hic",
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
    'http://localhost/api/parentalmonitorings',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'culpa',
            'type' => 'quo',
            'comment' => 'et',
            'answer' => 'beatae',
            'idParent' => 'ut',
            'idStudent' => 'sit',
            'idClasse' => 'illum',
            'idSchool' => 'hic',
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
<div id="execution-results-POSTapi-parentalmonitorings" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-parentalmonitorings"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-parentalmonitorings"></code></pre>
</div>
<div id="execution-error-POSTapi-parentalmonitorings" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-parentalmonitorings"></code></pre>
</div>
<form id="form-POSTapi-parentalmonitorings" data-method="POST" data-path="api/parentalmonitorings" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-parentalmonitorings', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/parentalmonitorings</code></b>
</p>
<p>
<label id="auth-POSTapi-parentalmonitorings" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-parentalmonitorings" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>comment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="comment" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>answer</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="answer" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idParent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idParent" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idStudent" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idClasse" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-parentalmonitorings" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-parentalmonitorings" data-component="body"  hidden>
<br>

</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/parentalmonitorings/eius" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"a","type":"sed","comment":"aliquam","answer":"accusantium","idParent":"nobis","idStudent":"dolor","idClasse":"soluta","idSchool":"voluptate","idSection":{}}'

```

```javascript
const url = new URL(
    "http://localhost/api/parentalmonitorings/eius"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "a",
    "type": "sed",
    "comment": "aliquam",
    "answer": "accusantium",
    "idParent": "nobis",
    "idStudent": "dolor",
    "idClasse": "soluta",
    "idSchool": "voluptate",
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
    'http://localhost/api/parentalmonitorings/eius',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'a',
            'type' => 'sed',
            'comment' => 'aliquam',
            'answer' => 'accusantium',
            'idParent' => 'nobis',
            'idStudent' => 'dolor',
            'idClasse' => 'soluta',
            'idSchool' => 'voluptate',
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
<div id="execution-results-PUTapi-parentalmonitorings--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-parentalmonitorings--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-parentalmonitorings--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-parentalmonitorings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-parentalmonitorings--id-"></code></pre>
</div>
<form id="form-PUTapi-parentalmonitorings--id-" data-method="PUT" data-path="api/parentalmonitorings/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-parentalmonitorings--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/parentalmonitorings/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-parentalmonitorings--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-parentalmonitorings--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>comment</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="comment" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>answer</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="answer" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idParent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idParent" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idStudent</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idStudent" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idClasse</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idClasse" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idSection" data-endpoint="PUTapi-parentalmonitorings--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/parentalmonitorings/natus" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/parentalmonitorings/natus"
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
    'http://localhost/api/parentalmonitorings/natus',
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
<div id="execution-results-DELETEapi-parentalmonitorings--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-parentalmonitorings--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-parentalmonitorings--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-parentalmonitorings--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-parentalmonitorings--id-"></code></pre>
</div>
<form id="form-DELETEapi-parentalmonitorings--id-" data-method="DELETE" data-path="api/parentalmonitorings/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-parentalmonitorings--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/parentalmonitorings/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-parentalmonitorings--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-parentalmonitorings--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-parentalmonitorings--id-" data-component="url" required  hidden>
<br>

</p>
</form>



