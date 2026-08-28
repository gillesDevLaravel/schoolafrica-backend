# Listes personnalisees


## Récupère le résumé financier (pensions + frais) avec pagination.

<small class="badge badge-darkred">requires authentication</small>

La pagination est configurable via :
- `pageItems` : page actuelle
- `nbreItems` : nombre d'éléments par page

> Example request:

```bash
curl -X POST \
    "http://localhost/api/pensions-and-fees-list-period" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"pageItems":5,"nbreItems":12,"date_start":"22-11-2025","date_end":"22-11-2025","idSchool":13}'

```

```javascript
const url = new URL(
    "http://localhost/api/pensions-and-fees-list-period"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "pageItems": 5,
    "nbreItems": 12,
    "date_start": "22-11-2025",
    "date_end": "22-11-2025",
    "idSchool": 13
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
    'http://localhost/api/pensions-and-fees-list-period',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'pageItems' => 5,
            'nbreItems' => 12,
            'date_start' => '22-11-2025',
            'date_end' => '22-11-2025',
            'idSchool' => 13,
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
<div id="execution-results-POSTapi-pensions-and-fees-list-period" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-pensions-and-fees-list-period"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-pensions-and-fees-list-period"></code></pre>
</div>
<div id="execution-error-POSTapi-pensions-and-fees-list-period" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-pensions-and-fees-list-period"></code></pre>
</div>
<form id="form-POSTapi-pensions-and-fees-list-period" data-method="POST" data-path="api/pensions-and-fees-list-period" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-pensions-and-fees-list-period', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/pensions-and-fees-list-period</code></b>
</p>
<p>
<label id="auth-POSTapi-pensions-and-fees-list-period" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-pensions-and-fees-list-period" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>pageItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="pageItems" data-endpoint="POSTapi-pensions-and-fees-list-period" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>nbreItems</code></b>&nbsp;&nbsp;<small>integer</small>     <i>optional</i> &nbsp;
<input type="number" name="nbreItems" data-endpoint="POSTapi-pensions-and-fees-list-period" data-component="body"  hidden>
<br>

</p>
<p>
<b><code>date_start</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date_start" data-endpoint="POSTapi-pensions-and-fees-list-period" data-component="body" required  hidden>
<br>
The value must be a valid date in the format d-m-Y.
</p>
<p>
<b><code>date_end</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="date_end" data-endpoint="POSTapi-pensions-and-fees-list-period" data-component="body" required  hidden>
<br>
The value must be a valid date in the format d-m-Y.
</p>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-pensions-and-fees-list-period" data-component="body" required  hidden>
<br>

</p>

</form>



