# ExtraCashins


## Récupérer la liste des encaissements

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/extracashinsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":6,"nbreItems":17,"filter_value":"nihil","idClient":8,"irpp":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/extracashinsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 6,
    "nbreItems": 17,
    "filter_value": "nihil",
    "idClient": 8,
    "irpp": false
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
    'http://localhost/api/extracashinsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 6,
            'nbreItems' => 17,
            'filter_value' => 'nihil',
            'idClient' => 8,
            'irpp' => false,
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
<div id="execution-results-POSTapi-extracashinsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-extracashinsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-extracashinsall"></code></pre>
</div>
<div id="execution-error-POSTapi-extracashinsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-extracashinsall"></code></pre>
</div>
<form id="form-POSTapi-extracashinsall" data-method="POST" data-path="api/extracashinsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-extracashinsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/extracashinsall</code></b>
</p>
<p>
<label id="auth-POSTapi-extracashinsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-extracashinsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-extracashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-extracashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-extracashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClient" data-endpoint="POSTapi-extracashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-extracashinsall" hidden><input type="radio" name="irpp" value="true" data-endpoint="POSTapi-extracashinsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-extracashinsall" hidden><input type="radio" name="irpp" value="false" data-endpoint="POSTapi-extracashinsall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Enregistrer un nouvel encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/extracashins" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClient":18,"amount_to_receive":2204.56829,"amount_received":87.06246427,"reason":"possimus","payment_method":"architecto","irpp":false,"payment_date":"2026-03-04","receipt_number":"est","operator":"iusto","idTypeOfRecipe":1}'

```

```javascript
const url = new URL(
    "http://localhost/api/extracashins"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClient": 18,
    "amount_to_receive": 2204.56829,
    "amount_received": 87.06246427,
    "reason": "possimus",
    "payment_method": "architecto",
    "irpp": false,
    "payment_date": "2026-03-04",
    "receipt_number": "est",
    "operator": "iusto",
    "idTypeOfRecipe": 1
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
    'http://localhost/api/extracashins',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClient' => 18,
            'amount_to_receive' => 2204.56829,
            'amount_received' => 87.06246427,
            'reason' => 'possimus',
            'payment_method' => 'architecto',
            'irpp' => false,
            'payment_date' => '2026-03-04',
            'receipt_number' => 'est',
            'operator' => 'iusto',
            'idTypeOfRecipe' => 1,
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
<div id="execution-results-POSTapi-extracashins" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-extracashins"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-extracashins"></code></pre>
</div>
<div id="execution-error-POSTapi-extracashins" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-extracashins"></code></pre>
</div>
<form id="form-POSTapi-extracashins" data-method="POST" data-path="api/extracashins" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-extracashins', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/extracashins</code></b>
</p>
<p>
<label id="auth-POSTapi-extracashins" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-extracashins" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClient" data-endpoint="POSTapi-extracashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>amount_to_receive</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_to_receive" data-endpoint="POSTapi-extracashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_received</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_received" data-endpoint="POSTapi-extracashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-extracashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_method" data-endpoint="POSTapi-extracashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-extracashins" hidden><input type="radio" name="irpp" value="true" data-endpoint="POSTapi-extracashins" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-extracashins" hidden><input type="radio" name="irpp" value="false" data-endpoint="POSTapi-extracashins" data-component="body" required ><code>false</code></label>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_date" data-endpoint="POSTapi-extracashins" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="POSTapi-extracashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-extracashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="POSTapi-extracashins" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les informations d&#039;un encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/extracashins/doloremque" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/extracashins/doloremque"
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
    'http://localhost/api/extracashins/doloremque',
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
<div id="execution-results-GETapi-extracashins--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-extracashins--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-extracashins--id-"></code></pre>
</div>
<div id="execution-error-GETapi-extracashins--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-extracashins--id-"></code></pre>
</div>
<form id="form-GETapi-extracashins--id-" data-method="GET" data-path="api/extracashins/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-extracashins--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/extracashins/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-extracashins--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-extracashins--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-extracashins--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Mettre à jour les infos d&#039;un encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/extracashins/nihil" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClient":5,"amount_to_receive":22229251.86,"amount_received":68.56854,"reason":"quae","payment_method":"nisi","irpp":false,"payment_date":"2026-03-04T18:39:14+0000","receipt_number":"voluptas","operator":"adipisci","idTypeOfRecipe":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/extracashins/nihil"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClient": 5,
    "amount_to_receive": 22229251.86,
    "amount_received": 68.56854,
    "reason": "quae",
    "payment_method": "nisi",
    "irpp": false,
    "payment_date": "2026-03-04T18:39:14+0000",
    "receipt_number": "voluptas",
    "operator": "adipisci",
    "idTypeOfRecipe": 11
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
    'http://localhost/api/extracashins/nihil',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClient' => 5,
            'amount_to_receive' => 22229251.86,
            'amount_received' => 68.56854,
            'reason' => 'quae',
            'payment_method' => 'nisi',
            'irpp' => false,
            'payment_date' => '2026-03-04T18:39:14+0000',
            'receipt_number' => 'voluptas',
            'operator' => 'adipisci',
            'idTypeOfRecipe' => 11,
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
<div id="execution-results-PUTapi-extracashins--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-extracashins--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-extracashins--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-extracashins--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-extracashins--id-"></code></pre>
</div>
<form id="form-PUTapi-extracashins--id-" data-method="PUT" data-path="api/extracashins/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-extracashins--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/extracashins/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-extracashins--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-extracashins--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-extracashins--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClient" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_to_receive</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_to_receive" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_received</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_received" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_method" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-extracashins--id-" hidden><input type="radio" name="irpp" value="true" data-endpoint="PUTapi-extracashins--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-extracashins--id-" hidden><input type="radio" name="irpp" value="false" data-endpoint="PUTapi-extracashins--id-" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_date" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="PUTapi-extracashins--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Envoyer un encaissement à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/extracashins/trash/hic" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/extracashins/trash/hic"
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
    'http://localhost/api/extracashins/trash/hic',
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
<div id="execution-results-DELETEapi-extracashins-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-extracashins-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-extracashins-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-extracashins-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-extracashins-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-extracashins-trash--id-" data-method="DELETE" data-path="api/extracashins/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-extracashins-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/extracashins/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-extracashins-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-extracashins-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-extracashins-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer un encaissement de la corbeille
Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/extracashins/restore/error" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/extracashins/restore/error"
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
    'http://localhost/api/extracashins/restore/error',
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
<div id="execution-results-POSTapi-extracashins-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-extracashins-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-extracashins-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-extracashins-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-extracashins-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-extracashins-restore--id-" data-method="POST" data-path="api/extracashins/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-extracashins-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/extracashins/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-extracashins-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-extracashins-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-extracashins-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>



