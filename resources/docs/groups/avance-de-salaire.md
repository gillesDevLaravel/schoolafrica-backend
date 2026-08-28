# Avance de salaire
Gestion des avances sur salaire

## Lister les avances de salaires

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-advancesall" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":6,"nbreItems":5,"filter_value":"perferendis","trashed":false,"idUser":5,"idUserApprove":5,"date":"2025-11-22"}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-advancesall"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 6,
    "nbreItems": 5,
    "filter_value": "perferendis",
    "trashed": false,
    "idUser": 5,
    "idUserApprove": 5,
    "date": "2025-11-22"
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
    'http://localhost/api/salary-advancesall',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 6,
            'nbreItems' => 5,
            'filter_value' => 'perferendis',
            'trashed' => false,
            'idUser' => 5,
            'idUserApprove' => 5,
            'date' => '2025-11-22',
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
<div id="execution-results-POSTapi-salary-advancesall" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-advancesall"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-advancesall"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-advancesall" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-advancesall"></code></pre>
</div>
<form id="form-POSTapi-salary-advancesall" data-method="POST" data-path="api/salary-advancesall" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-advancesall', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-advancesall</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-advancesall" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-advancesall" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-salary-advancesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-salary-advancesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>filter_value</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="filter_value" data-endpoint="POSTapi-salary-advancesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>trashed</code></b>&nbsp;&nbsp;<small>boolean</small>     <i>optional</i> &nbsp;
<label data-endpoint="POSTapi-salary-advancesall" hidden><input type="radio" name="trashed" value="true" data-endpoint="POSTapi-salary-advancesall" data-component="body" ><code>true</code></label>
<label data-endpoint="POSTapi-salary-advancesall" hidden><input type="radio" name="trashed" value="false" data-endpoint="POSTapi-salary-advancesall" data-component="body" ><code>false</code></label>
<br>

</p>
<p>
<b><code>idUser</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUser" data-endpoint="POSTapi-salary-advancesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="idUserApprove" data-endpoint="POSTapi-salary-advancesall" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="date" data-endpoint="POSTapi-salary-advancesall" data-component="body"  hidden>
<br>
Le champ value n'est pas une date valide. The value must be a valid date in the format Y-m-d.
</p>

</form>


## Initier une ou plusieurs avances de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-advances" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"salary_advances":[{"idUserApprove":7,"amount":"molestiae","reason":"consequuntur"}]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-advances"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "salary_advances": [
        {
            "idUserApprove": 7,
            "amount": "molestiae",
            "reason": "consequuntur"
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
    'http://localhost/api/salary-advances',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'salary_advances' => [
                [
                    'idUserApprove' => 7,
                    'amount' => 'molestiae',
                    'reason' => 'consequuntur',
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
<div id="execution-results-POSTapi-salary-advances" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-advances"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-advances"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-advances" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-advances"></code></pre>
</div>
<form id="form-POSTapi-salary-advances" data-method="POST" data-path="api/salary-advances" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-advances', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-advances</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-advances" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-advances" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<details>
<summary>
<b><code>salary_advances</code></b>&nbsp;&nbsp;<small>object[]</small>     <i>optional</i> &nbsp;
<br>

</summary>
<br>
<p>
<b><code>salary_advances[].idUserApprove</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="salary_advances.0.idUserApprove" data-endpoint="POSTapi-salary-advances" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>salary_advances[].amount</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_advances.0.amount" data-endpoint="POSTapi-salary-advances" data-component="body" required  hidden>
<br>

</p>
<p>
<b><code>salary_advances[].reason</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_advances.0.reason" data-endpoint="POSTapi-salary-advances" data-component="body" required  hidden>
<br>

</p>
</details>
</p>

</form>


## Afficher les détails d&#039;unn avance de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/salary-advances/sint" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/salary-advances/sint"
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
    'http://localhost/api/salary-advances/sint',
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
<div id="execution-results-GETapi-salary-advances--salary_advance-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-salary-advances--salary_advance-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-salary-advances--salary_advance-"></code></pre>
</div>
<div id="execution-error-GETapi-salary-advances--salary_advance-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-salary-advances--salary_advance-"></code></pre>
</div>
<form id="form-GETapi-salary-advances--salary_advance-" data-method="GET" data-path="api/salary-advances/{salary_advance}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-salary-advances--salary_advance-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/salary-advances/{salary_advance}</code></b>
</p>
<p>
<label id="auth-GETapi-salary-advances--salary_advance-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="GETapi-salary-advances--salary_advance-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>salary_advance</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_advance" data-endpoint="GETapi-salary-advances--salary_advance-" data-component="url" required  hidden>
<br>

</p>
</form>


## Mettre à jour une demande d&#039;avance de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X PUT \
    "http://localhost/api/salary-advances/et" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idUserApprove":{},"amount":{},"status":"in_progress","reason":"eligendi","comments":"occaecati"}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-advances/et"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idUserApprove": {},
    "amount": {},
    "status": "in_progress",
    "reason": "eligendi",
    "comments": "occaecati"
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
    'http://localhost/api/salary-advances/et',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idUserApprove' => [],
            'amount' => [],
            'status' => 'in_progress',
            'reason' => 'eligendi',
            'comments' => 'occaecati',
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
<div id="execution-results-PUTapi-salary-advances--salary_advance-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-salary-advances--salary_advance-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-salary-advances--salary_advance-"></code></pre>
</div>
<div id="execution-error-PUTapi-salary-advances--salary_advance-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-salary-advances--salary_advance-"></code></pre>
</div>
<form id="form-PUTapi-salary-advances--salary_advance-" data-method="PUT" data-path="api/salary-advances/{salary_advance}" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-salary-advances--salary_advance-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/salary-advances/{salary_advance}</code></b>
</p>
<p>
<label id="auth-PUTapi-salary-advances--salary_advance-" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="PUTapi-salary-advances--salary_advance-" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>salary_advance</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="salary_advance" data-endpoint="PUTapi-salary-advances--salary_advance-" data-component="url" required  hidden>
<br>

</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idUserApprove</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="idUserApprove" data-endpoint="PUTapi-salary-advances--salary_advance-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>amount</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="amount" data-endpoint="PUTapi-salary-advances--salary_advance-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>status</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="status" data-endpoint="PUTapi-salary-advances--salary_advance-" data-component="body"  hidden>
<br>
The value must be one of <code>pending_approval</code>, <code>in_progress</code>, <code>approved</code>, or <code>rejected</code>.
</p>
<p>
<b><code>reason</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="reason" data-endpoint="PUTapi-salary-advances--salary_advance-" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>comments</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="text" name="comments" data-endpoint="PUTapi-salary-advances--salary_advance-" data-component="body"  hidden>
<br>

</p>

</form>


## Archiver une ou plusieurs avances de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-advances/trash" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[4,11]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-advances/trash"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        4,
        11
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
    'http://localhost/api/salary-advances/trash',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                4,
                11,
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
<div id="execution-results-POSTapi-salary-advances-trash" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-advances-trash"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-advances-trash"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-advances-trash" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-advances-trash"></code></pre>
</div>
<form id="form-POSTapi-salary-advances-trash" data-method="POST" data-path="api/salary-advances/trash" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-advances-trash', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-advances/trash</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-advances-trash" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-advances-trash" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-salary-advances-trash" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-salary-advances-trash" data-component="body" hidden>
<br>

</p>

</form>


## Restaurer une ou plusieurs avances de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-advances/restore" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[17,8]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-advances/restore"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        17,
        8
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
    'http://localhost/api/salary-advances/restore',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                17,
                8,
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
<div id="execution-results-POSTapi-salary-advances-restore" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-advances-restore"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-advances-restore"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-advances-restore" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-advances-restore"></code></pre>
</div>
<form id="form-POSTapi-salary-advances-restore" data-method="POST" data-path="api/salary-advances/restore" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-advances-restore', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-advances/restore</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-advances-restore" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-advances-restore" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-salary-advances-restore" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-salary-advances-restore" data-component="body" hidden>
<br>

</p>

</form>


## Supprimer une ou plusieurs avances de salaire

<small class="badge badge-darkred">requires authentication</small>



> Example request:

```bash
curl -X POST \
    "http://localhost/api/salary-advances/delete" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"ids":[12,19]}'

```

```javascript
const url = new URL(
    "http://localhost/api/salary-advances/delete"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "ids": [
        12,
        19
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
    'http://localhost/api/salary-advances/delete',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'ids' => [
                12,
                19,
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
<div id="execution-results-POSTapi-salary-advances-delete" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-salary-advances-delete"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-salary-advances-delete"></code></pre>
</div>
<div id="execution-error-POSTapi-salary-advances-delete" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-salary-advances-delete"></code></pre>
</div>
<form id="form-POSTapi-salary-advances-delete" data-method="POST" data-path="api/salary-advances/delete" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-salary-advances-delete', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/salary-advances/delete</code></b>
</p>
<p>
<label id="auth-POSTapi-salary-advances-delete" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-salary-advances-delete" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>ids</code></b>&nbsp;&nbsp;<small>integer[]</small>  &nbsp;
<input type="number" name="ids.0" data-endpoint="POSTapi-salary-advances-delete" data-component="body" required  hidden>
<input type="number" name="ids.1" data-endpoint="POSTapi-salary-advances-delete" data-component="body" hidden>
<br>

</p>

</form>



