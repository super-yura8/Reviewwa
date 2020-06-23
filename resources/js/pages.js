class Api {
    static getReview(url) {
        return axios.get(url)
            .then(result => result.data);
    }
}

export default Api;
