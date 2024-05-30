# API-TRANSFER

## Desenvolvimento

### Subir servidor de desenvolvimento (Linux)

```
docker-compose -f ./containers/developer/docker-compose.dev.yml up
```

### <b>Portas</b>

- 7001 => API-transfer
- 3306 => MySQL
- 6379 => Redis

## Produção

### Subir servidor de produção

- Em construção

## Endpoints

```http request
POST /transfer

{
  "value": "FLOAT",
  "payer": "INT",
  "payee": "INT"
}
```
