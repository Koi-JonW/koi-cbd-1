import $ from 'jquery';

import { format } from 'date-fns';

export default class ProductReview {
  constructor(opts) {
    this.baseUrl = opts.baseUrl;
    this.appId = opts.appId;
    this.reviewId = opts.id;
    this.voting = opts.voting;
    this.showRating = opts.showRating;
    this.upvotes = opts.votesUp;
    this.downvotes = opts.votesDown;
    this.score = opts.score;
    this.alreadyVoted = false;
    this.$review = $(opts.review);

    if (this.voting) {
      // detectVotes() needs $upvote/$downvote
      this.$upvote = this.$review.find('.k-arrow--up');
      this.$upvoteCount = this.$review.find('.k-review__upvote-count-target');
      this.$downvote = this.$review.find('.k-arrow--down');
      this.$downvoteCount = this.$review.find(
        '.k-review__downvote-count-target'
      );
      this.detectVotes();
      this.appendVoteListeners();
    }

    if (this.showRating) {
      this.showReviewScore();
    }
  }

  showReviewScore() {
    this.$title = this.$review.find('h3');
    this.$titleContainer = this.$review.find('.k-review--title');

    for (let i = 0; i < this.score; i++) {
      this.$titleContainer.append(/*html*/ `
        <div class="k-review__gold-star k-goldstar k-goldstar--${i}">
          <div class="k-goldstar--liner">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 49.57 47.14">
              <g id="Layer_2" data-name="Layer 2">
                <g id="Layer_1-2" data-name="Layer 1">
                  <polygon style="fill: #f4b13e" points="24.78 0 32.44 15.52 49.57 18.01 37.18 30.09 40.1 47.14 24.78 39.09 9.47 47.14 12.39 30.09 0 18.01 17.13 15.52 24.78 0"/>
                </g>
              </g>
            </svg>
          </div>
        </div>
      `);
    }
    /*
      We need to know when all the reviews have 
    */
    window.__reviewsLoaded.push(this);
  }

  detectVotes() {
    this.userVote = window.localStorage.getItem(`yotpo_vote-${this.reviewId}`);
    if (this.userVote === 'up') {
      this.$upvote.addClass('k-arrow--voted');
    } else if (this.userVote === 'down') {
      this.$downvote.addClass('k-arrow--voted');
    }
  }

  async postVote(action) {
    $.ajax({
      url: `https://api.yotpo.com/reviews/${this.reviewId}/vote/${action}`,
      method: 'POST',
    });
  }

  appendVoteListeners() {
    this.$upvote.click(() => {
      this.handleVote(this.$upvote);
      if (!this.alreadyVoted) {
        this.$upvote.addClass('k-arrow--voted');
        this.$upvoteCount.text(`${this.upvotes + 1}`);
      }
    });

    this.$downvote.click(() => {
      this.handleVote(this.$downvote);
      if (!this.alreadyVoted) {
        this.$downvote.addClass('k-arrow--voted');
        this.$downvoteCount.text(`${this.downvotes + 1}`);
      }
    });
  }

  handleVote(element) {
    /*
      The goal of the use of localStorage is to prevent vote spamming/manipulation.
      This also means we can use the value here to identify if we need to set the up/down
      icon as active for the user.

      If possible, it may be better to set this on a WP user level.
    */
    console.log('--- BEFORE')
    if (window.localStorage.getItem(`yotpo_vote-${this.reviewId}`)) {
      // the user has already voted on this item.
      this.alreadyVoted = true;
      alert('you have already voted on this review.');
      element.removeClass('k-arrow--voted');
      return;
    }
    console.log('--- AFTER')

    if (element === this.$upvote) {
      this.postVote('up');
      window.localStorage.setItem(`yotpo_vote-${this.reviewId}`, 'up');
    } else if (element === this.$downvote) {
      this.postVote('down');
      window.localStorage.setItem(`yotpo_vote-${this.reviewId}`, 'down');
    }
  }

  getMarkup(review) {
    const { title, content, user, votes_up, votes_down, id } = review;
    let { created_at } = review;

    created_at = format(new Date(created_at), 'MMMM dd, yyyy');

    const markup = /*html*/ `
      <article class="k-review" data-review-id="${id}">
        <div class="k-review--liner">
          <div class="k-review--title">
            <h3 class="k-weight--lg">${title}</h3>
          </div>
          <div class="k-review--body">
            <p>${content}</p>
          </div>
          <div class="k-review--meta">
            <p>${created_at} - ${user.display_name}</p>
          </div>
          <div class="k-review--actions">
            <div class="k-review--actions__item">
              <div class="k-arrow k-arrow--up">
                <div class="k-arrow--liner">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-up-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="16 12 12 8 8 12"></polyline>
                    <line x1="12" y1="16" x2="12" y2="8"></line>
                  </svg>
                </div>
              </div>
              <p class="k-review__upvote-count-target">${votes_up}</p>
            </div>
            <div class="k-review--actions__item">
              <div class="k-arrow k-arrow--down">
                <div class="k-arrow--liner">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-arrow-down-circle">
                    <circle cx="12" cy="12" r="10"></circle>
                    <polyline points="8 12 12 16 16 12"></polyline>
                    <line x1="12" y1="8" x2="12" y2="16"></line>
                  </svg>
                </div>
              </div>
              <p class="k-review__downvote-count-target">${votes_down}</p>
            </div>
          </div>
        </div>
      </article>
    `;

    return markup;
  }
}
