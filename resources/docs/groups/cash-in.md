# Cash_In


## Récupérer la liste des encaissements

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashinsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":14,"nbreItems":16,"filter_value":"autem","date_start":"2026-03-11T10:55:27+0000","date_end":"2026-03-11T10:55:27+0000","idClient":19,"idTypeOfRecipe":15,"irpp":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashinsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 14,
    "nbreItems": 16,
    "filter_value": "autem",
    "date_start": "2026-03-11T10:55:27+0000",
    "date_end": "2026-03-11T10:55:27+0000",
    "idClient": 19,
    "idTypeOfRecipe": 15,
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
    'http://localhost/api/cashinsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 14,
            'nbreItems' => 16,
            'filter_value' => 'autem',
            'date_start' => '2026-03-11T10:55:27+0000',
            'date_end' => '2026-03-11T10:55:27+0000',
            'idClient' => 19,
            'idTypeOfRecipe' => 15,
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
<div id="execution-results-POSTapi-cashinsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashinsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashinsall"></code></pre>
</div>
<div id="execution-error-POSTapi-cashinsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashinsall"></code></pre>
</div>
<form id="form-POSTapi-cashinsall" data-method="POST" data-path="api/cashinsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashinsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashinsall</code></b>
</p>
<p>
<label id="auth-POSTapi-cashinsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashinsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClient" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="POSTapi-cashinsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-cashinsall" hidden><input type="radio" name="irpp" value="true" data-endpoint="POSTapi-cashinsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-cashinsall" hidden><input type="radio" name="irpp" value="false" data-endpoint="POSTapi-cashinsall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Enregistrer un nouveau encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashins" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClient":5,"amount_to_receive":2799585.33639,"amount_received":0.7,"reason":"distinctio","payment_method":"autem","irpp":false,"payment_date":"2026-03-11","receipt_number":"eos","operator":"et","idTypeOfRecipe":2}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashins"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClient": 5,
    "amount_to_receive": 2799585.33639,
    "amount_received": 0.7,
    "reason": "distinctio",
    "payment_method": "autem",
    "irpp": false,
    "payment_date": "2026-03-11",
    "receipt_number": "eos",
    "operator": "et",
    "idTypeOfRecipe": 2
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
    'http://localhost/api/cashins',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClient' => 5,
            'amount_to_receive' => 2799585.33639,
            'amount_received' => 0.7,
            'reason' => 'distinctio',
            'payment_method' => 'autem',
            'irpp' => false,
            'payment_date' => '2026-03-11',
            'receipt_number' => 'eos',
            'operator' => 'et',
            'idTypeOfRecipe' => 2,
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
<div id="execution-results-POSTapi-cashins" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashins"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashins"></code></pre>
</div>
<div id="execution-error-POSTapi-cashins" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashins"></code></pre>
</div>
<form id="form-POSTapi-cashins" data-method="POST" data-path="api/cashins" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashins', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashins</code></b>
</p>
<p>
<label id="auth-POSTapi-cashins" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashins" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idClient" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>amount_to_receive</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_to_receive" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_received</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_received" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="reason" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_method" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>  &nbsp;
<label data-endpoint="POSTapi-cashins" hidden><input type="radio" name="irpp" value="true" data-endpoint="POSTapi-cashins" data-component="body" required ><code>true</code></label>
<label data-endpoint="POSTapi-cashins" hidden><input type="radio" name="irpp" value="false" data-endpoint="POSTapi-cashins" data-component="body" required ><code>false</code></label>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payment_date" data-endpoint="POSTapi-cashins" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="POSTapi-cashins" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les informations d&#039;un encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/cashins/quam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cashins/quam"
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
    'http://localhost/api/cashins/quam',
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
<div id="execution-results-GETapi-cashins--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-cashins--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-cashins--id-"></code></pre>
</div>
<div id="execution-error-GETapi-cashins--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-cashins--id-"></code></pre>
</div>
<form id="form-GETapi-cashins--id-" data-method="GET" data-path="api/cashins/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-cashins--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/cashins/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-cashins--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-cashins--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-cashins--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Mettre à jour les infos d&#039;un encaissement

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/cashins/expedita" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idClient":15,"amount_to_receive":207963292.2228636,"amount_received":61.96839,"reason":"minima","payment_method":"impedit","irpp":false,"payment_date":"2026-03-11T10:55:27+0000","receipt_number":"ab","operator":"non","idTypeOfRecipe":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashins/expedita"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idClient": 15,
    "amount_to_receive": 207963292.2228636,
    "amount_received": 61.96839,
    "reason": "minima",
    "payment_method": "impedit",
    "irpp": false,
    "payment_date": "2026-03-11T10:55:27+0000",
    "receipt_number": "ab",
    "operator": "non",
    "idTypeOfRecipe": 13
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
    'http://localhost/api/cashins/expedita',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idClient' => 15,
            'amount_to_receive' => 207963292.2228636,
            'amount_received' => 61.96839,
            'reason' => 'minima',
            'payment_method' => 'impedit',
            'irpp' => false,
            'payment_date' => '2026-03-11T10:55:27+0000',
            'receipt_number' => 'ab',
            'operator' => 'non',
            'idTypeOfRecipe' => 13,
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
<div id="execution-results-PUTapi-cashins--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-cashins--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-cashins--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-cashins--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-cashins--id-"></code></pre>
</div>
<form id="form-PUTapi-cashins--id-" data-method="PUT" data-path="api/cashins/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-cashins--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/cashins/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-cashins--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-cashins--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-cashins--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idClient</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idClient" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_to_receive</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_to_receive" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount_received</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="amount_received" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>payment_method</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_method" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>irpp</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="PUTapi-cashins--id-" hidden><input type="radio" name="irpp" value="true" data-endpoint="PUTapi-cashins--id-" data-component="body" ><code>true</code></label>
<label data-endpoint="PUTapi-cashins--id-" hidden><input type="radio" name="irpp" value="false" data-endpoint="PUTapi-cashins--id-" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>payment_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="payment_date" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>receipt_number</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="receipt_number" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>operator</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="operator" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeOfRecipe</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeOfRecipe" data-endpoint="PUTapi-cashins--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Envoyer un encaissement à la corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/cashins/trash/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cashins/trash/et"
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
    'http://localhost/api/cashins/trash/et',
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
<div id="execution-results-DELETEapi-cashins-trash--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-cashins-trash--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-cashins-trash--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-cashins-trash--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-cashins-trash--id-"></code></pre>
</div>
<form id="form-DELETEapi-cashins-trash--id-" data-method="DELETE" data-path="api/cashins/trash/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-cashins-trash--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/cashins/trash/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-cashins-trash--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-cashins-trash--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-cashins-trash--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Restaurer un encaissement de la corbeille
Il n&#039;est pas possible de restaurer un élément qui n&#039;est pas ACUTELLEMENT à l&#039;état Corbeille

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashins/restore/est" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/cashins/restore/est"
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
    'http://localhost/api/cashins/restore/est',
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
<div id="execution-results-POSTapi-cashins-restore--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashins-restore--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashins-restore--id-"></code></pre>
</div>
<div id="execution-error-POSTapi-cashins-restore--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashins-restore--id-"></code></pre>
</div>
<form id="form-POSTapi-cashins-restore--id-" data-method="POST" data-path="api/cashins/restore/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashins-restore--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashins/restore/{id}</code></b>
</p>
<p>
<label id="auth-POSTapi-cashins-restore--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashins-restore--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="POSTapi-cashins-restore--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Met des encaissements à la corbeille (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashins/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[1,6]}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashins/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        1,
        6
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
    'http://localhost/api/cashins/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                1,
                6,
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
<div id="execution-results-POSTapi-cashins-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashins-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashins-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-cashins-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashins-trash"></code></pre>
</div>
<form id="form-POSTapi-cashins-trash" data-method="POST" data-path="api/cashins/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashins-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashins/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-cashins-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashins-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-cashins-trash" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-cashins-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaure des encaissements supprimés (soft delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashins/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[9,12]}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashins/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        9,
        12
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
    'http://localhost/api/cashins/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                9,
                12,
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
<div id="execution-results-POSTapi-cashins-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashins-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashins-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-cashins-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashins-restore"></code></pre>
</div>
<form id="form-POSTapi-cashins-restore" data-method="POST" data-path="api/cashins/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashins-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashins/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-cashins-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashins-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-cashins-restore" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-cashins-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprime définitivement des encaissements (hard delete).

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/cashins/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[9,4]}'

```

```javascript
const url = new URL(
    "http://localhost/api/cashins/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        9,
        4
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
    'http://localhost/api/cashins/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                9,
                4,
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
<div id="execution-results-POSTapi-cashins-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-cashins-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-cashins-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-cashins-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-cashins-delete"></code></pre>
</div>
<form id="form-POSTapi-cashins-delete" data-method="POST" data-path="api/cashins/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-cashins-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/cashins/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-cashins-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-cashins-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>     <i>optional</i> &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-cashins-delete" data-component="body"  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-cashins-delete" data-component="body" hidden>
<br>

</p>

</form>



