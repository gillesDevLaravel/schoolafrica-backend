# Classe


## Afficher la liste des classes

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/classesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":13,"idSection":15,"idLevel":4,"idTeacher":17,"idOptionLevel":14,"pageItems":15,"nbreItems":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/classesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 13,
    "idSection": 15,
    "idLevel": 4,
    "idTeacher": 17,
    "idOptionLevel": 14,
    "pageItems": 15,
    "nbreItems": 11
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
    'http://localhost/api/classesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 13,
            'idSection' => 15,
            'idLevel' => 4,
            'idTeacher' => 17,
            'idOptionLevel' => 14,
            'pageItems' => 15,
            'nbreItems' => 11,
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
<div id="execution-results-POSTapi-classesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-classesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-classesall"></code></pre>
</div>
<div id="execution-error-POSTapi-classesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-classesall"></code></pre>
</div>
<form id="form-POSTapi-classesall" data-method="POST" data-path="api/classesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-classesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/classesall</code></b>
</p>
<p>
<label id="auth-POSTapi-classesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-classesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-classesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-classesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-classesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTeacher" data-endpoint="POSTapi-classesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-classesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-classesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-classesall" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les infos d&#039;une classe

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/classes/earum" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/classes/earum"
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
    'http://localhost/api/classes/earum',
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
<div id="execution-results-GETapi-classes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-classes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-classes--id-"></code></pre>
</div>
<div id="execution-error-GETapi-classes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-classes--id-"></code></pre>
</div>
<form id="form-GETapi-classes--id-" data-method="GET" data-path="api/classes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-classes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/classes/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-classes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-classes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-classes--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter une classe

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/classes" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d ''

```

```javascript
const url = new URL(
    "http://localhost/api/classes"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = 

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/classes',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'classes' => [
                [
                    'name' => 'rerum',
                    'idLevel' => 13,
                    'idTeacher' => 1,
                    'idOptionLevel' => 10,
                    'description' => 'officia',
                    'photo' => null,
                    'nextClasses' => [
                        16,
                        1,
                    ],
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
<div id="execution-results-POSTapi-classes" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-classes"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-classes"></code></pre>
</div>
<div id="execution-error-POSTapi-classes" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-classes"></code></pre>
</div>
<form id="form-POSTapi-classes" data-method="POST" data-path="api/classes" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-classes', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/classes</code></b>
</p>
<p>
<label id="auth-POSTapi-classes" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-classes" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>classes</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>classes[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="classes.0.name" data-endpoint="POSTapi-classes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>classes[].idLevel</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="classes.0.idLevel" data-endpoint="POSTapi-classes" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>classes[].idTeacher</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="classes.0.idTeacher" data-endpoint="POSTapi-classes" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>classes[].idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="classes.0.idOptionLevel" data-endpoint="POSTapi-classes" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>classes[].description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="classes.0.description" data-endpoint="POSTapi-classes" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>classes[].photo</code></b>&nbsp;&nbsp;<small>file</small>     <i>optional</i> &nbsp;
<input type="file" name="classes.0.photo" data-endpoint="POSTapi-classes" data-component="body"  hidden>
<br>
Le champ value doit être une image.
</p>
<p>
<b><code>classes[].nextClasses</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="classes.0.nextClasses.0" data-endpoint="POSTapi-classes" data-component="body" required  hidden>
<input type="number" name="classes.0.nextClasses.1" data-endpoint="POSTapi-classes" data-component="body" hidden>
<br>

</p>
</details>
</p>

</form>


## Maj des infos d&#039;une classe

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/classes/deleniti" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/classes/deleniti"
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
    'http://localhost/api/classes/deleniti',
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
<div id="execution-results-PUTapi-classes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-classes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-classes--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-classes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-classes--id-"></code></pre>
</div>
<form id="form-PUTapi-classes--id-" data-method="PUT" data-path="api/classes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-classes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/classes/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-classes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-classes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-classes--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer une classe

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/classes/ut" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/classes/ut"
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
    'http://localhost/api/classes/ut',
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
<div id="execution-results-DELETEapi-classes--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-classes--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-classes--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-classes--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-classes--id-"></code></pre>
</div>
<form id="form-DELETEapi-classes--id-" data-method="DELETE" data-path="api/classes/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-classes--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/classes/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-classes--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-classes--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-classes--id-" data-component="url" required  hidden>
<br>

</p>
</form>



