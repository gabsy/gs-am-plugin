# Gabi Schiopu AM API Plugin

<img width="1001" alt="CleanShot 2024-05-13 at 17 34 11@2x" src="https://github.com/gabsy/gs-am-plugin/assets/871700/c12c0950-629d-4769-acd5-53a36abb7c8c">

On plugin activation a custom table is created for data caching purposes. It stores the endpoint, data and expiration timestamp. The data is first fetched and stored to table when the admin page is open or the plugin block is used. The main data fetching function, ```make_data_request``` is checking the cached data, if it exists and not expired it returns it, otherwise it performs an API call for getting a new set of data.

This function is also hooked as action of an AJAX endpoint, set for both private and non private access, used for fetching data on block editor and on block template rendering.
The REFRESH DATA button is also using this endpoint for refreshing the data on admin page. It doesnt force a new API call, it just gets the cached data if not expired, and performs a new API call if the data is expired.

<img width="1126" alt="CleanShot 2024-05-13 at 17 45 32@2x" src="https://github.com/gabsy/gs-am-plugin/assets/871700/b30ac2c7-aeb9-4d4f-8c2f-a23325ab9aa3">

The block , ```Gabi API Data Block```, has the columns show/hide settings and also a setting to store the data as attributes and display from attributes only, even if the cached data has changed. Loading the block on the frontend does NOT perfom a new API call if the cached is expired, it displays only cached data or the data from attributes.

<img width="400" alt="CleanShot 2024-05-13 at 18 00 44@2x" src="https://github.com/gabsy/gs-am-plugin/assets/871700/18809363-5c22-4407-90d0-ef666f642700">

The custom WP-CLI command is set, by running ```wp gs-api-data refresh``` the API call is 'forced', through a bool argument, ```$is_forced``` passed as true to the data fetching function.

