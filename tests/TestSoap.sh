#!/bin/zsh

curl -vk --key "./TEST.pem" -E "./TEST_CERT.pem" -H "Content-Type: text/xml" -H "SOAPAction: \"\"" --data-binary @soap_envelope.xml https://localhost:443/api/test
