# Stistique Classe


## Statistiques par niveau et classe avec nombre de filles et garçons.

<small class="badge badge-darkred">requires authentication</small>

Retourne, pour une école donnée, la liste des niveaux avec leurs classes
ainsi que le nombre total de filles et de garçons par classe.

> Example request:

```bash
curl -X POST \
    "http://localhost/api/classes/statistics" \
    -H "Authorization: Bearer {YOUR_AUTH_KEY}" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"idSchool":3}'

```

```javascript
const url = new URL(
    "http://localhost/api/classes/statistics"
);

let headers = {
    "Authorization": "Bearer {YOUR_AUTH_KEY}",
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "idSchool": 3
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
    'http://localhost/api/classes/statistics',
    [
        'headers' => [
            'Authorization' => 'Bearer {YOUR_AUTH_KEY}',
            'Accept' => 'application/json',
        ],
        'json' => [
            'idSchool' => 3,
        ],
    ]
);
$body = $response->getBody();
print_r(json_decode((string) $body));
```


> Example response (200):

```json
{
    "success": true,
    "data": [
        {
            "niveau": {
                "id": 1,
                "name": "Sixième"
            },
            "classes": [
                {
                    "id": 5,
                    "classe": "Sixième A",
                    "girls_count": 12,
                    "boys_count": 15
                }
            ]
        }
    ],
    "message": "Statistiques récupérées avec succès"
}
```
> Example response (404):

```json
{
    "success": false,
    "message": "École introuvable"
}
```
> Example response (500):

```json
{
    "success": false,
    "message": "Une erreur est survenue"
}
```
<div id="execution-results-POSTapi-classes-statistics" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-classes-statistics"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-classes-statistics"></code></pre>
</div>
<div id="execution-error-POSTapi-classes-statistics" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-classes-statistics"></code></pre>
</div>
<form id="form-POSTapi-classes-statistics" data-method="POST" data-path="api/classes/statistics" data-authed="1" data-hasfiles="0" data-headers='{"Authorization":"Bearer {YOUR_AUTH_KEY}","Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-classes-statistics', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/classes/statistics</code></b>
</p>
<p>
<label id="auth-POSTapi-classes-statistics" hidden>Authorization header: <b><code>Bearer </code></b><input type="text" name="Authorization" data-prefix="Bearer " data-endpoint="POSTapi-classes-statistics" data-component="header"></label>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>idSchool</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="idSchool" data-endpoint="POSTapi-classes-statistics" data-component="body" required  hidden>
<br>
ID de l'école.
</p>

</form>



