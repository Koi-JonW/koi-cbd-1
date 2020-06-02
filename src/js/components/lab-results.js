import $ from 'jquery';
import Fuse from 'fuse.js';
import Test from '../helpers/Test';
import { $body } from '../global/selectors';

/**
 * // TODO
 * This whole process should be re-evaluated if given time.
 * The original solution was to have GSL push to the test-results-api
 * and use that data on the frontend. Now, there is the concept of
 * default results (essentially another dataset) making the "source of truth"
 * difficult to identify.
 */

let sampleTests = undefined;

if ($body.hasClass('page-template-lab-results')) {
  getResults();

  let counter = 0;
  const waiting = setInterval(() => {
    counter++;
    if (counter === 100) {
      // 10 seconds since ajax request
      alert('Error getting results from test database.');
      clearInterval(waiting);
    }
    if (sampleTests !== undefined) {
      setDefaultResults();
      clearInterval(waiting);
    }
  }, 100);
}

const $resultsForm = $('#k-resultssearch');
const $insertTarget = $('#resultsembedtarget');
const $tabAppendTarget = $('.k-recentresults__tab-append-target');
const $recentTestTarget = $('.k-recentresults__test-append-target');
const $spacer = $('.k-recentresults__spacer');

const fuseOpts = {
  shouldSort: true,
  threshold: 0.0,
  location: 0,
  distance: 100,
  maxPatternLength: 32,
  minMatchCharLength: 3,
  includeScore: true,
  keys: [/* 'type', 'flavor',*/ 'batchid' /*, 'productsku', 'ordername' */],
};

$resultsForm.submit(displayResults);

function setDefaultResults() {
  window.__defaults = [
    {
      categoryName: 'tinctures',
      sku: [
        'NATNAT250',
        'NATNAT500',
        'NATNAT1000',
        // 'NATNAT1500' - exists but isnt listed on PDP
        'NATNAT2000',
        // 'NATNAT3000' - exists but isnt listed on PDP
      ],
      button: $('[data-category="tincture"]'),
      unit: ['30mL Bottle'],
      labResults: [],
    },
    {
      categoryName: 'gummies',
      sku: ['REGGUM20', 'SRGUM20'],
      button: $('[data-category="gummies"]'),
      unit: ['20 Gummies'],
      labResults: [],
    },
    {
      categoryName: 'sprays',
      sku: ['NATNAT1500', 'NATNAT3000'],
      button: $('[data-category="sprays"]'),
      unit: ['60mL Bottle'],
      labResults: [],
    },
    {
      categoryName: 'vape',
      sku: ['WHTKOI100', 'WHTKOI250', 'WHTKOI500', 'WHTKOI1000'],
      button: $('[data-category="vape"]'),
      unit: ['30mL bottle'],
      labResults: [],
    },
    {
      categoryName: 'balms',
      sku: ['KPB150MG', 'KHB500', 'KHB1000'],
      button: $('[data-category="balms"]'),
      unit: ['45g Container'],
      labResults: [],
    },
    {
      categoryName: 'lotion',
      sku: ['LTNCTBRST', 'LTNLAV', 'LTNPNKGRP'],
      button: $('[data-category="lotion"]'),
      unit: ['4.25oz Bottle'],
      labResults: [],
    },
    {
      categoryName: 'petChew',
      sku: ['KPTSCHEWS'],
      button: $('[data-category="petChew"]'),
      unit: ['25 Chews'],
      labResults: [],
    },
    {
      categoryName: 'petSpray',
      sku: ['PETSPRY'],
      button: $('[data-category="petSpray"]'),
      unit: ['60mL Spray Bottle'],
      labResults: [],
    },
    {
      categoryName: 'hempFlower',
      sku: ['HeavensKush4G', 'FLW-NAT-1RL-0001'],
      button: $('[data-category="hempFlower"]'),
      unit: ['4 G Tin', '1 G Pre-roll'],
      alias: {
        name: ['Hemp Flower - Tin', 'Hemp Flower - Pre-roll'],
        variant: ["Heaven's Kush", 'Hawaiian Haze'],
      },
      labResults: [],
    },
    {
      categoryName: 'inhalers',
      sku: ['INH-MOJ-002-1000', 'INH-DRM-002-1000'],
      button: $('[data-category="inhalers"]'),
      unit: ['2 mL inhaler'],
      labResults: [],
    },
    {
      categoryName: 'softgels',
      sku: ['CAP-NAT-030-0750', 'CAP-MLT-030-0750'],
      button: $('[data-category="softgels"]'),
      unit: ['30-capsule bottle'],
      labResults: [],
    },
    {
      categoryName: 'bathBombs',
      sku: ['BATHBOMBORANGE', 'BATHBOMBBLUE', 'BATHBOMBGREEN'],
      button: $('[data-category="bathBombs"]'),
      unit: ['100mg bath bomb'],
      labResults: [],
    },
    {
      categoryName: 'rollOn',
      sku: ['ROG-MEN-089-0500'],
      button: $('[data-category="rollOn"]'),
      unit: ['3 oz roll-on bottle'],
      alias: {
        variant: ['500 mg'],
      },
      labResults: [],
    },
    {
      categoryName: 'skincare',
      sku: ['SKN-CLN-100-0500', 'SKN-TNR-100-0500', 'SKN-SER-030-0500', 'SKN-MST-050-0500'],
      button: $('[data-category="skincare"]'),
      unit: ['3.38 oz bottle', '1.69 oz bottle', '1.01 oz bottle', '1.69 oz bottle'],
      alias: {
        names: ['CBD Skincare | Facial Cleanser', 'CBD Skincare | Tightening Toner', 
          'CBD Skincare | Facial Serum', 'CBD Skincare | Moisturizer Cream'],
        variant: ['Facial Cleanser (500 mg)', 'Tightening Toner (500 mg)', 
          'Facial Serum (500 mg)', 'Moisturizer Cream (500 mg)'],
      },
      labResults: [],
    },
    {
      categoryName: 'hempShots',
      sku: ['SHT-RSP-073-0025-12PK', 'SHT-WTM-073-0025-12PK', 'SHT-PCH-073-0025-12PK'],
      button: $('[data-category="hempShots"]'),
      unit: ['2.5 oz bottle', '2.5 oz bottle', '2.5 oz bottle'],
      alias: {
        names: ['Koi Hemp Wellness Shot Raspberry Punch 25 mg', 'Koi Hemp Wellness Shot Watermelon 25 mg', 
          'Koi Hemp Sleep-Aid Shot Peach Iced Tea 25 mg'],
        variant: ['Raspberry Punch (25mg)', 'Watermelon (25mg)', 'Peach Iced Tea (25mg)'],
      },
      labResults: [],
    },
  ];

  // sync massaged data to global sampleTests
  window.__defaults.forEach(category => {
    category.sku.forEach((sku, index) => {
      // for each sku inside each category
      if (sku != undefined) {
        let globalMatch = sampleTests.filter(
          test => test.productsku === sku
        )[0];

        if (globalMatch) {
          globalMatch.unit = category.unit;
          globalMatch.defaultIndex = index;

          if (category.alias) {
            globalMatch.alias = {
              name: category.alias.name[index],
              variant: category.alias.variant[index],
            };
          }

          category.labResults.push(new Test(globalMatch));
        } else {
          console.log(globalMatch);
        }
      }
    });

    category.button.click(function(event) {
      showRecentTest({
        match: category.labResults[0],
        category,
        context: 'category',
      });
      $body.animate(
        {
          scrollTop: $spacer.offset().top - 100,
        },
        50
      );
    });
  });
}

function showRecentTest({ match, category, context }) {
  $recentTestTarget.html(``);
  appendMarkup({
    match,
    category,
    $appendTarget: $recentTestTarget,
    context,
  });
}

function getResults() {
  const RESULTS_URL = 'https://koi-test-results-api.herokuapp.com/results';
  const url = window.location.href.split('/lab-results')[0];
  $.ajax({
    url: `${RESULTS_URL}`,
    method: 'GET',
    complete: ({ responseJSON }) => {
      try {
        sampleTests = responseJSON.data;
      } catch (error) {
        $insertTarget.append(/*html*/ `
          <div class="k-latestbatch__results">
            <div class="k-latestbatch__results-liner k-latestbatch__results-liner--error">
              <h1>Sorry, there appears to be a connection issue.</h1>
              <p>Try refreshing the page.</p>
              <p>If you continue to experience a problem, please <a href="${url}/contact" style="text-decoration: underline;">let us know</a> and we'll be happy to help.</p>
            </div>
          </div>
        `);
        console.warn(responseJSON);
        console.error(Error(error));
      }
    },
  });
}

function displayResults(e) {
  e.preventDefault();

  const $t = $(this);
  const f = new Fuse(sampleTests, fuseOpts);
  const searchVal = $t.find('input[type="text"]').val();
  const results = f.search(searchVal);

  $insertTarget.empty();

  if (results.length > 0) {
    results.forEach(test => {
      test = new Test(test.item, test.score);
      appendMarkup({
        match: test,
        $appendTarget: $insertTarget,
        context: 'search',
      });
    });
  } else {
    displayTermPrompt();
  }
}

function displayTermPrompt() {
  $insertTarget.append(/*html*/ `
    <div class="k-latestbatch__results">
      <div class="k-latestbatch__results-liner k-latestbatch__results-liner--error">
        <h1>Sorry, we can't seem to find that.</h1>
        <!-- <p>Try searching for a product name, batch number, SKU, or strength.</p> -->
        <p>Try searching for a valid batch number.</p>
      </div>
    </div>    
  `);
}

function getTabMarkup(test, category, index) {
  const tab = /*html*/ `
    <div class="k-latestbatch--tabs__tab" data-product-sku="${
      test.productsku
    }" data-category="${category.categoryName}" data-category-index="${index}">
      <span class="k-latestbatch__variant-name">
        ${test.strength ? test.strength : test.ordername}
      </span>
    </div>
  `;

  return tab;
}

function appendVariantTabs(category) {
  // Display the variants as tabs
  let tabs = '';
  if (category.categoryName === 'lotion') {
    // lotion strength is *currently* always 200mg, so use the product name instead
    // this may change in the future as new products are added
    category.labResults.forEach((Test, index) => {
      Test.results.strength = Test.results.ordername
        .split('Koi Lotion')[1]
        .split('200')[0];
      tabs += getTabMarkup(Test.results, category, index);
    });
  } else if (category.categoryName === 'gummies') {
    // gummies *currently* only have 1 strength, so use the name instead.
    // this may change in the future as new products are added
    category.labResults.forEach((Test, index) => {
      Test.results.strength = Test.results.ordername
        .split('Koi')[1]
        .split('Fruit')[0];
      tabs += getTabMarkup(Test.results, category, index);
    });
  } else if (category.categoryName === 'hempFlower') {
    category.labResults.forEach((Test, index) => {
      Test.results.ordername = category.alias.name[index];
      Test.results.variantAlias = category.alias.variant[index];

      tabs += getTabMarkup(Test.results, category, index);
    });
  } else if (category) {
    category.labResults.forEach((Test, index) => {
      tabs += getTabMarkup(Test.results, category, index);
    });
  }
  $tabAppendTarget.html(tabs);
  assignTabListeners();
}

function getUnitIndex() {
  const { target } = event;

  if (target.dataset && target.dataset.categoryIndex) {
    return parseInt(event.target.dataset.categoryIndex);
  } else {
    return false;
  }
}

function evaluateCategoryUnits(index, category) {
  let visibleUnit;

  if (Array.isArray(category.unit)) {
    index = getUnitIndex();
    switch (true) {
      case index !== false && index < category.unit.length: {
        // ideal scenario
        visibleUnit = category.unit[index];
        break;
      }
      case index !== false && index >= category.unit.length: {
        // will occur if there are more SKUs than units declared in
        // the __defaults.
        visibleUnit = category.unit[category.unit.length - 1];
        break;
      }
      case !index: {
        // something happened to the index, but we know the unit is an array.
        // fallback to something that we know exists.
        visibleUnit = category.unit[0];
        break;
      }
      default: {
        visibleUnit = category.unit;
      }
    }
  } else if (category && category.unit) {
    visibleUnit = category.unit;
  }

  return visibleUnit;
}

function evaluateVariantAlias(test) {
  let alias;

  switch (true) {
    case typeof test.variantAlias === 'string': {
      alias = test.variantAlias;
      break;
    }
    case test.strength !== false: {
      alias = test.strength;
      break;
    }
    default: {
      alias = 'N/A';
    }
  }

  return alias;
}

function appendMarkup(signature) {
  try {
    const { $appendTarget, category, context } = signature;
    const { results: Test } = signature.match;

    let index = false;
    let visibleUnit;
    let variantAlias;

    switch (true) {
      case context === 'category': {
        appendVariantTabs(category);
        visibleUnit = evaluateCategoryUnits(index, category);
        variantAlias = evaluateVariantAlias(Test);
        break;
      }

      case context === 'recent-tab': {
        visibleUnit = evaluateCategoryUnits(index, category);
        variantAlias = evaluateVariantAlias(Test);
        break;
      }

      case context === 'search': {
        // evaluate the variantAlias
        switch (true) {
          case typeof Test.alias === 'object': {
            if (typeof Test.alias.name === 'string') {
              variantAlias = Test.alias.name;
            }
            break;
          }
          case typeof Test.strength === 'string': {
            variantAlias = Test.strength;
            break;
          }
          default: {
            variantAlias = 'N/A';
          }
        }

        // evaluate the visibleUnit
        switch (true) {
          case Array.isArray(Test.unit): {
            if (Test.defaultIndex < Test.unit.length) {
              visibleUnit = Test.unit[Test.defaultIndex];
            } else {
              visibleUnit = Test.unit[Test.unit.length - 1];
            }
            break;
          }

          case category: {
            if (Array.isArray(category.unit)) {
              visibleUnit = category.unit[Test.defaultIndex];
            } else {
              visibleUnit = category.unit;
            }

            break;
          }

          default: {
            visibleUnit = 'N/A';
          }
        }

        break;
      }

      default: {
        return false;
      }
    }

    $appendTarget.append(/*html*/ `
    <div class="k-latestbatch__results">
      <div class="k-latestbatch__results-liner">
        <div class="k-latestbatch__results-column">
          <div>
            <p class="k-headline k-headline--sm">${Test.ordername}</p>
          </div>
        </div>
        <div class="k-latestbatch__results-column">
          <div>
            <p class="k-latestbatch--strength">Variant: ${variantAlias}</p>
            ${
              visibleUnit
                ? `<p class="k-latestbatch--size">Size: ${visibleUnit}</p>`
                : ''
            }
            <p class="k-latestbatch--batch">Batch #: ${Test.batchid}</p>
          </div>
        </div>
        <div class="k-latestbatch__results-column">
          <a id="k-coaurl" class="k-button" href="${
            Test.coaurl
          }" target="_blank">View this product's Certificate of Analysis (COA)</a>
        </div>
      </div>
    </div>
  `);
  } catch (error) {
    console.error(Error(error));
    $tabAppendTarget.html(``);
    $appendTarget.append(/*html*/ `
      <div class="k-latestbatch__results k-result-error">
        <div class="k-latestbatch__error">
          <h2>We had trouble loading these Lab Results.</h2>
          <p>Have your batch number? Search for it below.</p>
        </div>
        <div class="k-latestbatch__results-liner" style="filter: blur(2px);">
          <div class="k-latestbatch__results-column">
            <div>
              <p class="k-upcase k-latestbatch--strength">
                100 MG
              </p>
              <p class="k-upcase k-latestbatch--strength">Batch #9075XXXXXX</p>
            </div>
          </div>
          <div class="k-latestbatch__results-column">
            <div>
              <p class="k-upcase">Product Name: CBD Vape Juice</p>
              <p class="k-upcase">Product SKU: XXXXXXXXXX</p>
            </div>
          </div>
          <div class="k-latestbatch__results-column">
            <p class="k-bigtext">
              <span class="k-weight--md">
                N/D
              </span>
              <span class="k-measurement">Total THC</span><br>
              <span class="k-upcase" style="font-size: 75%">View total CBD in PDF</span>
            </p>
          </div>
          <div class="k-latestbatch__results-column">
            <a id="k-coaurl" class="k-button" href="#" target="_blank">.PDF &darr;</a>
          </div>
        </div>
      </div>
    `);
  }
}

function assignTabListeners() {
  const $tabs = $('.k-latestbatch--tabs__tab');
  $tabs.first().addClass('active');

  $tabs.click(function() {
    const $t = $(this);
    $tabs.removeClass('active');
    $t.addClass('active');

    const category = window.__defaults.filter(
      cat => cat.categoryName === $t.data('category')
    )[0];

    const matchingTest = category.labResults.filter(
      test => test.results.productsku === $t.data('product-sku')
    )[0];

    $recentTestTarget.html(``);
    appendMarkup({
      match: matchingTest,
      $appendTarget: $recentTestTarget,
      category,
      context: 'recent-tab',
    });
  });
}
