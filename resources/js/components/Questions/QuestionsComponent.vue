<template>
  <div class="qa-component">
    <h2>Ask a Question  <i class="fa fa-paper-plane"></i></h2>
    <form @submit.prevent="submitQuestion">
      <input
        v-model="question"
        type="text"
        placeholder="Type your question..."
        class="question-input"
        @input="fetchSuggestions"
        autocomplete="off"
      />
      <ul v-if="suggestions.length" class="suggestions-list">
        <li
          v-for="(s, index) in suggestions"
          :key="index"
          @click="selectSuggestion(s)"
        >
          {{ s }}
        </li>
      </ul>

      <button type="submit" :disabled="loading" class="btn btn-danger m-3">
        <i class="fa fa-paper-plane"></i>
        {{ loading ? "Thinking..." : " Ask " }}
      </button>

    <button class="btn btn-danger m-3" style="background-color: red" @click="clearAll"><i class="fa fa-trash"></i> Clear</button>

    </form>

    <div v-if="answer" class="answer-box">
      <h3>Answer:</h3>
      <p>{{ answer }}</p>
    </div>

    <div v-if="error" class="error-box">
      {{ error }}
    </div>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "QAComponent",
  data() {
    return {
      question: "",
      answer: null,
      error: null,
      loading: false,
      suggestions: [],
      suggestionTimeout: null,
    };
  },
  methods: {
    //get type hint
    async fetchSuggestions() {
      clearTimeout(this.suggestionTimeout);

      if (!this.question.trim()) {
        this.suggestions = [];
        return;
      }

      // debounce requests
      this.suggestionTimeout = setTimeout(async () => {
        try {
          const response = await axios.get("/api/suggestions", {
            params: { q: this.question },
          });
          this.suggestions = response.data; // expects an array of question strings
        } catch (err) {
          console.error(err);
          this.suggestions = [];
        }
      }, 300); // 300ms debounce
    },

    selectSuggestion(s) {
      this.question = s;
      this.suggestions = [];
    },

    //send question  /api/ask?question=question
    async submitQuestion() {
      if (!this.question.trim()) {
        this.error = "Please enter a question.";
        return;
      }

      this.loading = true;
      this.answer = null;
      this.error = null;
      this.suggestions = [];

      try {

        //Post variant
        /*
        const response = await axios.post("/api/ask", {
          question: this.question,
        });
        */

        //Get variant
        const response = await axios.get("/api/ask", {
           params: {
              question: this.question
           }
        });


        this.answer = response.data.answer;
      } catch (err) {
        console.error(err);
        this.error =
          err.response?.data?.message || "Something went wrong. Please try again.";
      } finally {
        this.loading = false;
      }
    },

    //clear
    clearAll() {
      this.question = "";
      this.answer = null;
      this.error = null;
      this.suggestions = [];
    },

  },
};
</script>

<style scoped>
.qa-component {
  max-width: 500px;
  margin: 2rem auto;
  padding: 1rem;
  border: 1px solid #ddd;
  border-radius: 8px;
  background: #fafafa;
}
.question-input {
  width: 100%;
  padding: 0.5rem;
  margin-bottom: 0.25rem;
  border-radius: 4px;
  border: 1px solid #ccc;
}
.suggestions-list {
  border: 1px solid #ccc;
  border-top: none;
  background: white;
  list-style: none;
  margin: 0;
  padding: 0;
  max-height: 150px;
  overflow-y: auto;
}
.suggestions-list li {
  padding: 0.5rem;
  cursor: pointer;
}
.suggestions-list li:hover {
  background: #f0f0f0;
}
button {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  background: #0d6efd;
  color: white;
  cursor: pointer;
  margin-top: 0.5rem;
}
button:disabled {
  background: #6c757d;
  cursor: not-allowed;
}
.answer-box {
  margin-top: 1rem;
  padding: 0.5rem;
  border-left: 4px solid #0d6efd;
  background: #e9f0ff;
}
.error-box {
  margin-top: 1rem;
  color: #d9534f;
  font-weight: bold;
}
</style>