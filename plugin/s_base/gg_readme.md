pip3.7 install --upgrade google-api-python-client --ignore-installed

{
  "entries": [
    {
      "batchId": 33,
      "destinations": [
        "SurfacesAcrossGoogle"
      ],
      "merchantId": 275380900,
      "method": "get",
      "productId": "online:vi:VN:shopify_VN_FM0001"
    }
  ]
}

{
	"kind": "content#productstatusesCustomBatchResponse",
	"entries": [{
		"kind": "content#productstatusesCustomBatchResponseEntry",
		"batchId": 33,
		"productStatus": {
			"kind": "content#productStatus",
			"productId": "online:vi:VN:shopify_VN_FM0001",
			"title": "Face Mask",
			"destinationStatuses": [{
					"destination": "DisplayAds",
					"status": "disapproved",
					"disapprovedCountries": [
						"VN"
					]
				},
				{
					"destination": "SurfacesAcrossGoogle",
					"status": "disapproved",
					"disapprovedCountries": [
						"VN"
					]
				}
			],
			"itemLevelIssues": [{
					"code": "description_short",
					"servability": "unaffected",
					"resolution": "merchant_action",
					"attributeName": "description",
					"destination": "SurfacesAcrossGoogle",
					"description": "Text too short [description]",
					"detail": "Add a more detailed description for your product",
					"documentation": "https://support.google.com/merchants/answer/6098336",
					"applicableCountries": [
						"VN"
					]
				},
				{
					"code": "strong_id_inaccurate",
					"servability": "disapproved",
					"resolution": "merchant_action",
					"attributeName": "gtin",
					"destination": "SurfacesAcrossGoogle",
					"description": "Incorrect product identifier [gtin]",
					"detail": "Use the manufacturer's product identifiers (GTIN, brand, MPN)",
					"documentation": "https://support.google.com/merchants/answer/160161",
					"applicableCountries": [
						"VN"
					]
				},
				{
					"code": "image_link_internal_error",
					"servability": "disapproved",
					"resolution": "merchant_action",
					"attributeName": "image link",
					"destination": "SurfacesAcrossGoogle",
					"description": "Processing failed [image link]",
					"detail": "Wait for the product image to be crawled again (up to 3 days)",
					"documentation": "https://support.google.com/merchants/answer/6240184",
					"applicableCountries": [
						"VN"
					]
				},
				{
					"code": "policy_violation",
					"servability": "disapproved",
					"resolution": "merchant_action",
					"destination": "SurfacesAcrossGoogle",
					"description": "Violation of Shopping ads policy",
					"detail": "Review Shopping ads policies and update your feed to meet the requirements",
					"documentation": "https://support.google.com/merchants/answer/6149970",
					"applicableCountries": [
						"VN"
					]
				},
				{
					"code": "invalid_upc",
					"servability": "disapproved",
					"resolution": "merchant_action",
					"attributeName": "gtin",
					"destination": "SurfacesAcrossGoogle",
					"description": "Invalid value [gtin]",
					"detail": "Use a globally valid UPC",
					"documentation": "https://support.google.com/merchants/answer/6239388",
					"applicableCountries": [
						"VN"
					]
				},
				{
					"code": "url_does_not_match_homepage",
					"servability": "disapproved",
					"resolution": "merchant_action",
					"attributeName": "link",
					"destination": "SurfacesAcrossGoogle",
					"description": "Mismatched domains [link]",
					"detail": "Use the same domain for product landing page URLs as in your Merchant Center website setting",
					"documentation": "https://support.google.com/merchants/answer/160050",
					"applicableCountries": [
						"VN"
					]
				}
			],
			"creationDate": "2020-10-26T08:03:56Z",
			"lastUpdateDate": "2020-10-27T03:37:21Z",
			"googleExpirationDate": "2020-11-26T03:37:21Z"
		}
	}]
}
####

####
{
  "kind": "content#accountStatus",
  "accountId": "275380900",
  "websiteClaimed": true,
  "accountLevelIssues": [
    {
      "id": "missing_ad_words_link",
      "title": "No Google Ads account linked",
      "severity": "error",
      "documentation": "https://support.google.com/merchants/answer/6159060"
    }
  ]
}
