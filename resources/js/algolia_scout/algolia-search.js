// Algolia Autocomplete search box
// Imported from /resources/js/app.js

import { liteClient as algoliasearch } from 'algoliasearch/lite';
import {
    autocomplete,
    getAlgoliaResults,
} from '@algolia/autocomplete-js';

import '@algolia/autocomplete-theme-classic';

const searchContainer = document.querySelector('#global-search');

if (searchContainer) {

    const searchClient = algoliasearch(
        import.meta.env.VITE_ALGOLIA_APP_ID,
        import.meta.env.VITE_ALGOLIA_SEARCH_KEY
    );

    autocomplete({
        container: searchContainer,

        placeholder: 'Search products...',

        getSources({ query }) {

            if (!query.trim()) {
                return [];
            }

            return [
                {
                    sourceId: 'products',

                    getItems() {
                        return getAlgoliaResults({
                            searchClient,

                            queries: [
                                {
                                    indexName: 'products',

                                    query: query,

                                    params: {
                                        hitsPerPage: 8,
                                    },
                                },
                            ],
                        });
                    },

                    templates: {

                        item({ item, components, html }) {
                            return html`
                                <a
                                    href="/scout/${item.id}"
                                    class="search-result"
                                >
                                    <div class="search-result-name">
                                        ${components.Highlight({
                                            hit: item,
                                            attribute: 'name',
                                        })}
                                    </div>

                                    <div class="search-result-description">
                                        ${item.description ?? ''}
                                    </div>
                                </a>
                            `;
                        },

                    },
                },
            ];
        },

        onSubmit({ state }) {

            const query = state.query.trim();

            if (!query) {
                return;
            }

            window.location.href =
                `/search?q=${encodeURIComponent(query)}`;
        },
    });
}