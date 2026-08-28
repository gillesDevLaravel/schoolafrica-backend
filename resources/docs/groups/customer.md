# Customer


## Récupérer la liste des customers

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/customersall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"type":"quidem","filter_value":"alias","pageItems":11,"nbreItems":20}'

```

```javascript
const url = new URL(
    "http://localhost/api/customersall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "type": "quidem",
    "filter_value": "alias",
    "pageItems": 11,
    "nbreItems": 20
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
    'http://localhost/api/customersall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'type' => 'quidem',
            'filter_value' => 'alias',
            'pageItems' => 11,
            'nbreItems' => 20,
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
<div id="execution-results-POSTapi-customersall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-customersall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-customersall"></code></pre>
</div>
<div id="execution-error-POSTapi-customersall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-customersall"></code></pre>
</div>
<form id="form-POSTapi-customersall" data-method="POST" data-path="api/customersall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-customersall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/customersall</code></b>
</p>
<p>
<label id="auth-POSTapi-customersall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-customersall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-customersall" data-component="body"  hidden>
<br>
personnel/entreprise
</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-customersall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-customersall" data-component="body"  hidden>
<br>
Le numéro de la page de pagination
</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-customersall" data-component="body"  hidden>
<br>
Le nombre de résultats pour la page de pagination
</p>

</form>


## Afficher les informations d&#039;un customer

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/customers/2" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/customers/2"
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
    'http://localhost/api/customers/2',
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
<div id="execution-results-GETapi-customers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-customers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-customers--id-"></code></pre>
</div>
<div id="execution-error-GETapi-customers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-customers--id-"></code></pre>
</div>
<form id="form-GETapi-customers--id-" data-method="GET" data-path="api/customers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-customers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/customers/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-customers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-customers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-customers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Enregistrer un nouveau customer

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/customers" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"customers":[{"name":"est","adresse":"omnis","image":"dolorum","website":"sed","niu":"omnis","type":"entreprise","rc":"nisi","phone":"distinctio","mobile":"velit","email":"mavis.hermiston@example.net","country":"selmer.blick@example.com","city":"hritchie@example.org","cni":"xturner@example.org"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/customers"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "customers": [
        {
            "name": "est",
            "adresse": "omnis",
            "image": "dolorum",
            "website": "sed",
            "niu": "omnis",
            "type": "entreprise",
            "rc": "nisi",
            "phone": "distinctio",
            "mobile": "velit",
            "email": "mavis.hermiston@example.net",
            "country": "selmer.blick@example.com",
            "city": "hritchie@example.org",
            "cni": "xturner@example.org"
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
    'http://localhost/api/customers',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'customers' => [
                [
                    'name' => 'est',
                    'adresse' => 'omnis',
                    'image' => 'dolorum',
                    'website' => 'sed',
                    'niu' => 'omnis',
                    'type' => 'entreprise',
                    'rc' => 'nisi',
                    'phone' => 'distinctio',
                    'mobile' => 'velit',
                    'email' => 'mavis.hermiston@example.net',
                    'country' => 'selmer.blick@example.com',
                    'city' => 'hritchie@example.org',
                    'cni' => 'xturner@example.org',
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
<div id="execution-results-POSTapi-customers" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-customers"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-customers"></code></pre>
</div>
<div id="execution-error-POSTapi-customers" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-customers"></code></pre>
</div>
<form id="form-POSTapi-customers" data-method="POST" data-path="api/customers" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-customers', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/customers</code></b>
</p>
<p>
<label id="auth-POSTapi-customers" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-customers" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>customers</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>customers[].name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="customers.0.name" data-endpoint="POSTapi-customers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>customers[].adresse</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.adresse" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>customers[].image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.image" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>customers[].website</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.website" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>customers[].niu</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.niu" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>customers[].type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="customers.0.type" data-endpoint="POSTapi-customers" data-component="body" required  hidden>
<br>
The value must be one of <code>entreprise</code> or <code>personnel</code>.
</p>
<p>
<b><code>customers[].rc</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.rc" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>customers[].phone</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="customers.0.phone" data-endpoint="POSTapi-customers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>customers[].mobile</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="customers.0.mobile" data-endpoint="POSTapi-customers" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>customers[].email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="customers.0.email" data-endpoint="POSTapi-customers" data-component="body" required  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>customers[].country</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.country" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>customers[].city</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.city" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
<p>
<b><code>customers[].cni</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="customers.0.cni" data-endpoint="POSTapi-customers" data-component="body"  hidden>
<br>
Le champ value doit être une adresse email valide.
</p>
</details>
</p>

</form>


## Mettre à jour les infos d&#039;un customer

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/customers/1" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/customers/1"
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
    'http://localhost/api/customers/1',
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
<div id="execution-results-PUTapi-customers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-customers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-customers--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-customers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-customers--id-"></code></pre>
</div>
<form id="form-PUTapi-customers--id-" data-method="PUT" data-path="api/customers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-customers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/customers/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-customers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-customers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-customers--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un customer (si il n&#039;a pas encore de invoice)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/customers/11" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/customers/11"
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
    'http://localhost/api/customers/11',
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
<div id="execution-results-DELETEapi-customers--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-customers--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-customers--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-customers--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-customers--id-"></code></pre>
</div>
<form id="form-DELETEapi-customers--id-" data-method="DELETE" data-path="api/customers/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-customers--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/customers/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-customers--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-customers--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="DELETEapi-customers--id-" data-component="url" required  hidden>
<br>

</p>
</form>



