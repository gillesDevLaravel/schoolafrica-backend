# School Supplier


## Afficher la liste des fournitures scolaires

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schoolsuppliesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schoolsuppliesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "POST",
    headers,
}).then(response => response.json());
```

```php

$client = new \GuzzleHttp\Client();
$response = $client->post(
    'http://localhost/api/schoolsuppliesall',
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
<div id="execution-results-POSTapi-schoolsuppliesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schoolsuppliesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schoolsuppliesall"></code></pre>
</div>
<div id="execution-error-POSTapi-schoolsuppliesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schoolsuppliesall"></code></pre>
</div>
<form id="form-POSTapi-schoolsuppliesall" data-method="POST" data-path="api/schoolsuppliesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schoolsuppliesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schoolsuppliesall</code></b>
</p>
<p>
<label id="auth-POSTapi-schoolsuppliesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schoolsuppliesall" data-component="header"></label>
</p>
</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/schoolsupplies/autem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schoolsupplies/autem"
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
    'http://localhost/api/schoolsupplies/autem',
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
<div id="execution-results-GETapi-schoolsupplies--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-schoolsupplies--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-schoolsupplies--id-"></code></pre>
</div>
<div id="execution-error-GETapi-schoolsupplies--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-schoolsupplies--id-"></code></pre>
</div>
<form id="form-GETapi-schoolsupplies--id-" data-method="GET" data-path="api/schoolsupplies/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-schoolsupplies--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/schoolsupplies/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-schoolsupplies--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-schoolsupplies--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-schoolsupplies--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/schoolsupplies" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"supply":"rerum","idLevel":"aut","idSchool":"et","idSection":"atque","image":"facere","description":"repellat","idsClasses":[6,15]}'

```

```javascript
const url = new URL(
    "http://localhost/api/schoolsupplies"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "supply": "rerum",
    "idLevel": "aut",
    "idSchool": "et",
    "idSection": "atque",
    "image": "facere",
    "description": "repellat",
    "idsClasses": [
        6,
        15
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
    'http://localhost/api/schoolsupplies',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'supply' => 'rerum',
            'idLevel' => 'aut',
            'idSchool' => 'et',
            'idSection' => 'atque',
            'image' => 'facere',
            'description' => 'repellat',
            'idsClasses' => [
                6,
                15,
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
<div id="execution-results-POSTapi-schoolsupplies" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-schoolsupplies"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-schoolsupplies"></code></pre>
</div>
<div id="execution-error-POSTapi-schoolsupplies" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-schoolsupplies"></code></pre>
</div>
<form id="form-POSTapi-schoolsupplies" data-method="POST" data-path="api/schoolsupplies" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-schoolsupplies', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/schoolsupplies</code></b>
</p>
<p>
<label id="auth-POSTapi-schoolsupplies" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-schoolsupplies" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>supply</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="supply" data-endpoint="POSTapi-schoolsupplies" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idLevel" data-endpoint="POSTapi-schoolsupplies" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="POSTapi-schoolsupplies" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSection" data-endpoint="POSTapi-schoolsupplies" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image" data-endpoint="POSTapi-schoolsupplies" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-schoolsupplies" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idsClasses</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="idsClasses.0" data-endpoint="POSTapi-schoolsupplies" data-component="body"  hidden>
<input type="number" name="idsClasses.1" data-endpoint="POSTapi-schoolsupplies" data-component="body" hidden>
<br>

</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/schoolsupplies/nulla" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"supply":"esse","idLevel":"deleniti","idSchool":"doloremque","idSection":"ut","image":"soluta","description":"suscipit","idsClasses":[4,20]}'

```

```javascript
const url = new URL(
    "http://localhost/api/schoolsupplies/nulla"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "supply": "esse",
    "idLevel": "deleniti",
    "idSchool": "doloremque",
    "idSection": "ut",
    "image": "soluta",
    "description": "suscipit",
    "idsClasses": [
        4,
        20
    ]
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
    'http://localhost/api/schoolsupplies/nulla',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'supply' => 'esse',
            'idLevel' => 'deleniti',
            'idSchool' => 'doloremque',
            'idSection' => 'ut',
            'image' => 'soluta',
            'description' => 'suscipit',
            'idsClasses' => [
                4,
                20,
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
<div id="execution-results-PUTapi-schoolsupplies--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-schoolsupplies--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-schoolsupplies--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-schoolsupplies--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-schoolsupplies--id-"></code></pre>
</div>
<form id="form-PUTapi-schoolsupplies--id-" data-method="PUT" data-path="api/schoolsupplies/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-schoolsupplies--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/schoolsupplies/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-schoolsupplies--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-schoolsupplies--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-schoolsupplies--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>supply</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="supply" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idLevel" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSchool" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="idSection" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="image" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idsClasses</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="idsClasses.0" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body"  hidden>
<input type="number" name="idsClasses.1" data-endpoint="PUTapi-schoolsupplies--id-" data-component="body" hidden>
<br>

</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/schoolsupplies/consequatur" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/schoolsupplies/consequatur"
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
    'http://localhost/api/schoolsupplies/consequatur',
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
<div id="execution-results-DELETEapi-schoolsupplies--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-schoolsupplies--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-schoolsupplies--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-schoolsupplies--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-schoolsupplies--id-"></code></pre>
</div>
<form id="form-DELETEapi-schoolsupplies--id-" data-method="DELETE" data-path="api/schoolsupplies/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-schoolsupplies--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/schoolsupplies/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-schoolsupplies--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-schoolsupplies--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-schoolsupplies--id-" data-component="url" required  hidden>
<br>

</p>
</form>



