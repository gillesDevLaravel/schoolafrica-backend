# Invoice


## Afficher la liste des invoices

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/invoicesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":3,"idSection":1,"statut":"enim","mode":"velit","idTypeInvoice":16,"idProduct":17,"idUser":1,"date_start":"2025-11-22T14:46:33+0000","date_end":"2025-11-22T14:46:33+0000","typeUser":"sunt","pageItems":20,"nbreItems":7,"date":"quis","filter_value":"qui"}'

```

```javascript
const url = new URL(
    "http://localhost/api/invoicesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 3,
    "idSection": 1,
    "statut": "enim",
    "mode": "velit",
    "idTypeInvoice": 16,
    "idProduct": 17,
    "idUser": 1,
    "date_start": "2025-11-22T14:46:33+0000",
    "date_end": "2025-11-22T14:46:33+0000",
    "typeUser": "sunt",
    "pageItems": 20,
    "nbreItems": 7,
    "date": "quis",
    "filter_value": "qui"
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
    'http://localhost/api/invoicesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 3,
            'idSection' => 1,
            'statut' => 'enim',
            'mode' => 'velit',
            'idTypeInvoice' => 16,
            'idProduct' => 17,
            'idUser' => 1,
            'date_start' => '2025-11-22T14:46:33+0000',
            'date_end' => '2025-11-22T14:46:33+0000',
            'typeUser' => 'sunt',
            'pageItems' => 20,
            'nbreItems' => 7,
            'date' => 'quis',
            'filter_value' => 'qui',
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
<div id="execution-results-POSTapi-invoicesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-invoicesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoicesall"></code></pre>
</div>
<div id="execution-error-POSTapi-invoicesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoicesall"></code></pre>
</div>
<form id="form-POSTapi-invoicesall" data-method="POST" data-path="api/invoicesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoicesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/invoicesall</code></b>
</p>
<p>
<label id="auth-POSTapi-invoicesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-invoicesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>statut</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="statut" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
paid/unpaid
</p>
<p>
<b><code>mode</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="mode" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idTypeInvoice</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idTypeInvoice" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idProduct</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idProduct" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
ID du customer/user
</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>typeUser</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="typeUser" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
customer/user
</p>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
Le numéro de la page de pagination
</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
Le nombre de résultats pour la page de pagination
</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>Date</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-invoicesall" data-component="body"  hidden>
<br>
La valeur avec laquelle on veut effectuer le filtre
</p>

</form>


## Afficher les infos d&#039;un invoice

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/invoices/19" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/invoices/19"
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
    'http://localhost/api/invoices/19',
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
<div id="execution-results-GETapi-invoices--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-invoices--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-invoices--id-"></code></pre>
</div>
<div id="execution-error-GETapi-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-invoices--id-"></code></pre>
</div>
<form id="form-GETapi-invoices--id-" data-method="GET" data-path="api/invoices/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-invoices--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/invoices/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-invoices--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-invoices--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-invoices--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Ajouter un invoice

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/invoices" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"invoices":[{"amount":"beatae","reasons":"saepe","image":"maxime","payment_deadline":{},"date":"2025-11-22T14:46:33+0000","idSchool":4,"idSection":4,"statut":"unpaid","mode":"recusandae","typeUser":"user","idUser":5,"idTypeInvoice":11,"idProduct":1,"type_produit":"blanditiis","quantite":9,"prix_unitaire":2}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/invoices"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "invoices": [
        {
            "amount": "beatae",
            "reasons": "saepe",
            "image": "maxime",
            "payment_deadline": {},
            "date": "2025-11-22T14:46:33+0000",
            "idSchool": 4,
            "idSection": 4,
            "statut": "unpaid",
            "mode": "recusandae",
            "typeUser": "user",
            "idUser": 5,
            "idTypeInvoice": 11,
            "idProduct": 1,
            "type_produit": "blanditiis",
            "quantite": 9,
            "prix_unitaire": 2
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
    'http://localhost/api/invoices',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'invoices' => [
                [
                    'amount' => 'beatae',
                    'reasons' => 'saepe',
                    'image' => 'maxime',
                    'payment_deadline' => [],
                    'date' => '2025-11-22T14:46:33+0000',
                    'idSchool' => 4,
                    'idSection' => 4,
                    'statut' => 'unpaid',
                    'mode' => 'recusandae',
                    'typeUser' => 'user',
                    'idUser' => 5,
                    'idTypeInvoice' => 11,
                    'idProduct' => 1,
                    'type_produit' => 'blanditiis',
                    'quantite' => 9,
                    'prix_unitaire' => 2,
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
<div id="execution-results-POSTapi-invoices" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-invoices"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-invoices"></code></pre>
</div>
<div id="execution-error-POSTapi-invoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-invoices"></code></pre>
</div>
<form id="form-POSTapi-invoices" data-method="POST" data-path="api/invoices" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-invoices', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/invoices</code></b>
</p>
<p>
<label id="auth-POSTapi-invoices" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-invoices" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>invoices</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>invoices[].amount</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="invoices.0.amount" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>invoices[].reasons</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="invoices.0.reasons" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>invoices[].image</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="invoices.0.image" data-endpoint="POSTapi-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>invoices[].payment_deadline</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="invoices.0.payment_deadline" data-endpoint="POSTapi-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>invoices[].date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="invoices.0.date" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>invoices[].idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="invoices.0.idSchool" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>invoices[].idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="invoices.0.idSection" data-endpoint="POSTapi-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>invoices[].statut</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="invoices.0.statut" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>
The value must be one of <code>unpaid</code> or <code>paid</code>.
</p>
<p>
<b><code>invoices[].mode</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="invoices.0.mode" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>invoices[].typeUser</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="invoices.0.typeUser" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>
The value must be one of <code>customer</code> or <code>user</code>.
</p>
<p>
<b><code>invoices[].idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="invoices.0.idUser" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>invoices[].idTypeInvoice</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="invoices.0.idTypeInvoice" data-endpoint="POSTapi-invoices" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>invoices[].idProduct</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="invoices.0.idProduct" data-endpoint="POSTapi-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>invoices[].type_produit</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="invoices.0.type_produit" data-endpoint="POSTapi-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>invoices[].quantite</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="invoices.0.quantite" data-endpoint="POSTapi-invoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>invoices[].prix_unitaire</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="invoices.0.prix_unitaire" data-endpoint="POSTapi-invoices" data-component="body"  hidden>
<br>

</p>
</details>
</p>

</form>


## Modifier les infos d&#039;un invoice

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/invoices/8" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/invoices/8"
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
    'http://localhost/api/invoices/8',
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
<div id="execution-results-PUTapi-invoices--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-invoices--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-invoices--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-invoices--id-"></code></pre>
</div>
<form id="form-PUTapi-invoices--id-" data-method="PUT" data-path="api/invoices/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-invoices--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/invoices/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-invoices--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-invoices--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-invoices--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Supprimer un invoice

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X DELETE \
    "http://localhost/api/invoices/tempore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/invoices/tempore"
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
    'http://localhost/api/invoices/tempore',
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
<div id="execution-results-DELETEapi-invoices--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-DELETEapi-invoices--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-DELETEapi-invoices--id-"></code></pre>
</div>
<div id="execution-error-DELETEapi-invoices--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-DELETEapi-invoices--id-"></code></pre>
</div>
<form id="form-DELETEapi-invoices--id-" data-method="DELETE" data-path="api/invoices/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('DELETEapi-invoices--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-red">DELETE</small>
 <b><code>api/invoices/{id}</code></b>
</p>
<p>
<label id="auth-DELETEapi-invoices--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="DELETEapi-invoices--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="DELETEapi-invoices--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## api/statsinvoices

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/statsinvoices" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":18,"idSection":11}'

```

```javascript
const url = new URL(
    "http://localhost/api/statsinvoices"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 18,
    "idSection": 11
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
    'http://localhost/api/statsinvoices',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 18,
            'idSection' => 11,
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
<div id="execution-results-POSTapi-statsinvoices" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-statsinvoices"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-statsinvoices"></code></pre>
</div>
<div id="execution-error-POSTapi-statsinvoices" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-statsinvoices"></code></pre>
</div>
<form id="form-POSTapi-statsinvoices" data-method="POST" data-path="api/statsinvoices" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-statsinvoices', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/statsinvoices</code></b>
</p>
<p>
<label id="auth-POSTapi-statsinvoices" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-statsinvoices" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-statsinvoices" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-statsinvoices" data-component="body"  hidden>
<br>

</p>

</form>


## Statistiques des invoices en incluant les invoices de chaque type dans chaque mois

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/statsinvoicespartype" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":16,"idSection":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/statsinvoicespartype"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 16,
    "idSection": 13
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
    'http://localhost/api/statsinvoicespartype',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 16,
            'idSection' => 13,
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
<div id="execution-results-POSTapi-statsinvoicespartype" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-statsinvoicespartype"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-statsinvoicespartype"></code></pre>
</div>
<div id="execution-error-POSTapi-statsinvoicespartype" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-statsinvoicespartype"></code></pre>
</div>
<form id="form-POSTapi-statsinvoicespartype" data-method="POST" data-path="api/statsinvoicespartype" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-statsinvoicespartype', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/statsinvoicespartype</code></b>
</p>
<p>
<label id="auth-POSTapi-statsinvoicespartype" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-statsinvoicespartype" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-statsinvoicespartype" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-statsinvoicespartype" data-component="body"  hidden>
<br>

</p>

</form>


## Statistiques des entrées &amp; sorties par mois

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/statspermonth" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":6,"idSection":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/statspermonth"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 6,
    "idSection": 4
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
    'http://localhost/api/statspermonth',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 6,
            'idSection' => 4,
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
<div id="execution-results-POSTapi-statspermonth" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-statspermonth"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-statspermonth"></code></pre>
</div>
<div id="execution-error-POSTapi-statspermonth" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-statspermonth"></code></pre>
</div>
<form id="form-POSTapi-statspermonth" data-method="POST" data-path="api/statspermonth" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-statspermonth', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/statspermonth</code></b>
</p>
<p>
<label id="auth-POSTapi-statspermonth" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-statspermonth" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-statspermonth" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idSection</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idSection" data-endpoint="POSTapi-statspermonth" data-component="body"  hidden>
<br>

</p>

</form>



