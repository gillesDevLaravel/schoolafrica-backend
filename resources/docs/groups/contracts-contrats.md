# Contracts / Contrats

Gestion des contrats

## Lister les contrats avec option de filtre et de pagination

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/contractsall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":12,"nbreItems":16,"filter_value":"provident","position":"doloremque","status":"minus","trashed":false}'

```

```javascript
const url = new URL(
    "http://localhost/api/contractsall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 12,
    "nbreItems": 16,
    "filter_value": "provident",
    "position": "doloremque",
    "status": "minus",
    "trashed": false
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
    'http://localhost/api/contractsall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 12,
            'nbreItems' => 16,
            'filter_value' => 'provident',
            'position' => 'doloremque',
            'status' => 'minus',
            'trashed' => false,
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
<div id="execution-results-POSTapi-contractsall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-contractsall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-contractsall"></code></pre>
</div>
<div id="execution-error-POSTapi-contractsall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-contractsall"></code></pre>
</div>
<form id="form-POSTapi-contractsall" data-method="POST" data-path="api/contractsall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-contractsall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/contractsall</code></b>
</p>
<p>
<label id="auth-POSTapi-contractsall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-contractsall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-contractsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-contractsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-contractsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>position</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="position" data-endpoint="POSTapi-contractsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-contractsall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-contractsall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-contractsall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-contractsall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-contractsall" data-component="body" ><code>false</code></label>
<br>

</p>

</form>


## Création de contrat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/contracts" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":18,"idUserApprove":9,"type":"iste","description":"possimus","start_date":"2025-11-22T14:46:50+0000","duration":4,"working_hours":"distinctio","position":"officia","gross_salary":1075.4,"status":"terminated","service_benefits":"sint","bonus":"molestiae","file":"hic","number_days_off":4}'

```

```javascript
const url = new URL(
    "http://localhost/api/contracts"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 18,
    "idUserApprove": 9,
    "type": "iste",
    "description": "possimus",
    "start_date": "2025-11-22T14:46:50+0000",
    "duration": 4,
    "working_hours": "distinctio",
    "position": "officia",
    "gross_salary": 1075.4,
    "status": "terminated",
    "service_benefits": "sint",
    "bonus": "molestiae",
    "file": "hic",
    "number_days_off": 4
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
    'http://localhost/api/contracts',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 18,
            'idUserApprove' => 9,
            'type' => 'iste',
            'description' => 'possimus',
            'start_date' => '2025-11-22T14:46:50+0000',
            'duration' => 4,
            'working_hours' => 'distinctio',
            'position' => 'officia',
            'gross_salary' => 1075.4,
            'status' => 'terminated',
            'service_benefits' => 'sint',
            'bonus' => 'molestiae',
            'file' => 'hic',
            'number_days_off' => 4,
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
<div id="execution-results-POSTapi-contracts" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-contracts"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-contracts"></code></pre>
</div>
<div id="execution-error-POSTapi-contracts" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-contracts"></code></pre>
</div>
<form id="form-POSTapi-contracts" data-method="POST" data-path="api/contracts" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-contracts', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/contracts</code></b>
</p>
<p>
<label id="auth-POSTapi-contracts" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-contracts" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-contracts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-contracts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="type" data-endpoint="POSTapi-contracts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-contracts" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="start_date" data-endpoint="POSTapi-contracts" data-component="body" required  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="duration" data-endpoint="POSTapi-contracts" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>working_hours</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="working_hours" data-endpoint="POSTapi-contracts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>position</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="position" data-endpoint="POSTapi-contracts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>gross_salary</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="gross_salary" data-endpoint="POSTapi-contracts" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="POSTapi-contracts" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>approved</code>, or <code>terminated</code>.
</p>
<p>
<b><code>service_benefits</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="service_benefits" data-endpoint="POSTapi-contracts" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>bonus</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="bonus" data-endpoint="POSTapi-contracts" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>file</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="file" data-endpoint="POSTapi-contracts" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>number_days_off</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="number_days_off" data-endpoint="POSTapi-contracts" data-component="body"  hidden>
<br>

</p>

</form>


## Afficher les informations spécifiques a un contrat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/contracts/aliquam" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/contracts/aliquam"
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
    'http://localhost/api/contracts/aliquam',
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
<div id="execution-results-GETapi-contracts--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-contracts--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-contracts--id-"></code></pre>
</div>
<div id="execution-error-GETapi-contracts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-contracts--id-"></code></pre>
</div>
<form id="form-GETapi-contracts--id-" data-method="GET" data-path="api/contracts/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-contracts--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/contracts/{id}</code></b>
</p>
<p>
<label id="auth-GETapi-contracts--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-contracts--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="GETapi-contracts--id-" data-component="url" required  hidden>
<br>

</p>
</form>


## Modifier les informations d&#039;un contrat

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/contracts/dolore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUser":6,"idUserApprove":4,"type":"doloribus","description":"nihil","start_date":"2025-11-22T14:46:50+0000","duration":9,"working_hours":"velit","position":"quibusdam","gross_salary":0.34,"status":"terminated","service_benefits":"dolores","bonus":"ut","number_days_off":12}'

```

```javascript
const url = new URL(
    "http://localhost/api/contracts/dolore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUser": 6,
    "idUserApprove": 4,
    "type": "doloribus",
    "description": "nihil",
    "start_date": "2025-11-22T14:46:50+0000",
    "duration": 9,
    "working_hours": "velit",
    "position": "quibusdam",
    "gross_salary": 0.34,
    "status": "terminated",
    "service_benefits": "dolores",
    "bonus": "ut",
    "number_days_off": 12
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
    'http://localhost/api/contracts/dolore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUser' => 6,
            'idUserApprove' => 4,
            'type' => 'doloribus',
            'description' => 'nihil',
            'start_date' => '2025-11-22T14:46:50+0000',
            'duration' => 9,
            'working_hours' => 'velit',
            'position' => 'quibusdam',
            'gross_salary' => 0.34,
            'status' => 'terminated',
            'service_benefits' => 'dolores',
            'bonus' => 'ut',
            'number_days_off' => 12,
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
<div id="execution-results-PUTapi-contracts--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-contracts--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-contracts--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-contracts--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-contracts--id-"></code></pre>
</div>
<form id="form-PUTapi-contracts--id-" data-method="PUT" data-path="api/contracts/{id}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-contracts--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/contracts/{id}</code></b>
</p>
<p>
<label id="auth-PUTapi-contracts--id-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-contracts--id-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="id" data-endpoint="PUTapi-contracts--id-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>type</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="type" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="description" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>start_date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="start_date" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide.
</p>
<p>
<b><code>duration</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="duration" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>working_hours</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="working_hours" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>position</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="position" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>gross_salary</code></b>&nbsp;&nbsp;<small>number</small>     <i>optional</i> &nbsp;
<input type="number" name="gross_salary" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>approved</code>, or <code>terminated</code>.
</p>
<p>
<b><code>service_benefits</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="service_benefits" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>bonus</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="bonus" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>number_days_off</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="number_days_off" data-endpoint="PUTapi-contracts--id-" data-component="body"  hidden>
<br>

</p>

</form>


## Mise en corbeille multiple des contrats (Archivage)

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/contracts/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[8,14]}'

```

```javascript
const url = new URL(
    "http://localhost/api/contracts/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        8,
        14
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
    'http://localhost/api/contracts/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                8,
                14,
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
<div id="execution-results-POSTapi-contracts-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-contracts-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-contracts-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-contracts-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-contracts-trash"></code></pre>
</div>
<form id="form-POSTapi-contracts-trash" data-method="POST" data-path="api/contracts/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-contracts-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/contracts/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-contracts-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-contracts-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-contracts-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-contracts-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restauration multiple des contrats avec une liste d&#039;ids

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/contracts/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[8,2]}'

```

```javascript
const url = new URL(
    "http://localhost/api/contracts/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        8,
        2
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
    'http://localhost/api/contracts/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                8,
                2,
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
<div id="execution-results-POSTapi-contracts-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-contracts-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-contracts-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-contracts-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-contracts-restore"></code></pre>
</div>
<form id="form-POSTapi-contracts-restore" data-method="POST" data-path="api/contracts/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-contracts-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/contracts/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-contracts-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-contracts-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-contracts-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-contracts-restore" data-component="body" hidden>
<br>

</p>

</form>


## Suppression définitive des contrats déjà archivés

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/contracts/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[15,5]}'

```

```javascript
const url = new URL(
    "http://localhost/api/contracts/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        15,
        5
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
    'http://localhost/api/contracts/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                15,
                5,
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
<div id="execution-results-POSTapi-contracts-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-contracts-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-contracts-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-contracts-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-contracts-delete"></code></pre>
</div>
<form id="form-POSTapi-contracts-delete" data-method="POST" data-path="api/contracts/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-contracts-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/contracts/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-contracts-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-contracts-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-contracts-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-contracts-delete" data-component="body" hidden>
<br>

</p>

</form>



