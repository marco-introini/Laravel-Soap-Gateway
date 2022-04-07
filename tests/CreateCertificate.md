# Certificate Creation

## Self-signed for TEST

openssl genrsa -out TEST.pem 2048
openssl req -new -key TEST.pem -out req_TEST.csr

Password used: none (hit Return)

openssl req -x509 -key TEST.pem -in req_TEST.csr -out TEST_CERT.pem -days 3650


openssl pkcs12 -export -out TEST.pfx -inkey TEST.pem -in TEST_CERT.pem -passout pass:""

Password used: none (hit Return)