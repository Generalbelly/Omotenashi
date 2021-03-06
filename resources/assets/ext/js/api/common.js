import axios from 'axios'

import {
    BaseAPI,
} from '../../../js/api/common';

axios.defaults.baseURL = 'https://docker.omotenashi.today/api';
axios.defaults.headers.common['Authorization'] = `Bearer ${_ot_ext_token}`;

export default BaseAPI;