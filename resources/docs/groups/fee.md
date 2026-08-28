# Fee


## Listing des frais

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/feesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":6,"idSection":10,"idLevel":17,"idOptionLevel":9}'

```

```javascript
const url = new URL(
    "http://localhost/api/feesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 6,
    "idSection": 10,
    "idLevel": 17,
    "idOptionLevel": 9
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
    'http://localhost/api/feesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 6,
            'idSection' => 10,
            'idLevel' => 17,
            'idOptionLevel' => 9,
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
<div id="execution-results-POSTapi-feesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-feesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-feesall"></code></pre>
</div>
<div id="execution-error-POSTapi-feesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-feesall"></code></pre>
</div>
<form id="form-POSTapi-feesall" data-method="POST" data-path="api/feesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-feesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/feesall</code></b>
</p>
<p>
<label id="auth-POSTapi-feesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-feesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-feesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-feesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idLevel" data-endpoint="POSTapi-feesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idOptionLevel</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idOptionLevel" data-endpoint="POSTapi-feesall" data-component="body"  hidden>
<br>

</p>

</form>


## Display the specified resource.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/fees/dolorem" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/fees/dolorem"
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
    'http://localhost/api/fees/dolorem',
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
<div id="execution-results-GETapi-fees--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-fees--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-fees--id-"></code></pre>
</div>
<div id="execution-error-GETapi-fees--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-fees--id-"></code></pre>
</div>
<form id="form-GETapi-fees--id-" data-method="GET" data-path="api/fees/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-fees--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/fees/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-fees--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-fees--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-fees--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Store a newly created resource in storage.

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/fees" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"cumque","description":{},"price":"fugit","deadline":"doloribus","order":12,"required":false,"idSchool":7,"idSection":16,"idTypeOfRecipe":16}'

```

```javascript
const url = new URL(
    "http://localhost/api/fees"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "cumque",
    "description": {},
    "price": "fugit",
    "deadline": "doloribus",
    "order": 12,
    "required": false,
    "idSchool": 7,
    "idSection": 16,
    "idTypeOfRecipe": 16
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
    'http://localhost/api/fees',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'cumque',
            'description' => [],
            'price' => 'fugit',
            'deadline' => 'doloribus',
            'order' => 12,
            'required' => false,
            'idSchool' => 7,
            'idSection' => 16,
            'idTypeOfRecipe' => 16,
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
<div id="execution-results-POSTapi-fees" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-fees"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-fees"></code></pre>
</div>
<div id="execution-error-POSTapi-fees" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-fees"></code></pre>
</div>
<form id="form-POSTapi-fees" data-method="POST" data-path="api/fees" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-fees', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/fees</code></b>
</p>
<p>
<label id="auth-POSTapi-fees" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-fees" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-fees" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-fees" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="price" data-endpoint="POSTapi-fees" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>deadline</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="deadline" data-endpoint="POSTapi-fees" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>order</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="order" data-endpoint="POSTapi-fees" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>required</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-fees" hidden><input type="radio" name="required" value="true" data-endpoint="POSTapi-fees" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-fees" hidden><input type="radio" name="required" value="false" data-endpoint="POSTapi-fees" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-fees" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-fees" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="POSTapi-fees" data-component="body"  hidden>
<br>

</p>

</form>


## Update the specified resource in storage.

<small class="badge badge-darkred">requires authentication</small>

"name": "Registration","price": 25000, //Modifier le prix pour voir les differents cas "deadline": "2024-09-02","idSchool": 2,"idSection": 2}

> Example request:

```bash
curl -X PUT \
    "http://localhost/api/fees/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"voluptatem","description":{},"price":"ab","deadline":"eos","order":7,"required":false,"idSchool":6,"idSection":16,"idTypeOfRecipe":19}'

```

```javascript
const url = new URL(
    "http://localhost/api/fees/et"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "voluptatem",
    "description": {},
    "price": "ab",
    "deadline": "eos",
    "order": 7,
    "required": false,
    "idSchool": 6,
    "idSection": 16,
    "idTypeOfRecipe": 19
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
    'http://localhost/api/fees/et',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'name' => 'voluptatem',
            'description' => [],
            'price' => 'ab',
            'deadline' => 'eos',
            'order' => 7,
            'required' => false,
            'idSchool' => 6,
            'idSection' => 16,
            'idTypeOfRecipe' => 19,
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
<div id="execution-results-PUTapi-fees--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-fees--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-fees--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-fees--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-fees--id-"></code></pre>
</div>
<form id="form-PUTapi-fees--id-" data-method="PUT" data-path="api/fees/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-fees--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/fees/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-fees--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-fees--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-fees--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-fees--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-fees--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="price" data-endpoint="PUTapi-fees--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>deadline</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="deadline" data-endpoint="PUTapi-fees--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>order</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="order" data-endpoint="PUTapi-fees--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>required</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-fees--id-" hidden><input type="radio" name="required" value="true" data-endpoint="PUTapi-fees--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-fees--id-" hidden><input type="radio" name="required" value="false" data-endpoint="PUTapi-fees--id-" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="PUTapi-fees--id-" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="PUTapi-fees--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="PUTapi-fees--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Remove the specified resource from storage.

<small class="badge badge-darkred">requires authentication</small>

"name": "Registration","price": 25000, //Modifier le prix pour voir les differents cas "deadline": "2024-09-02","idSchool": 2,"idSection": 2}

> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/fees/odio" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/fees/odio"
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
    'http://localhost/api/fees/odio',
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
<div id="execution-results-DELETEapi-fees--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-fees--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-fees--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-fees--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-fees--id-"></code></pre>
</div>
<form id="form-DELETEapi-fees--id-" data-method="DELETE" data-path="api/fees/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-fees--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/fees/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-fees--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-fees--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-fees--id-" data-component="url" required  hidden>
<br>

</p>
</form>



