import axios from 'axios'

import {
    APIController,
} from '../../../js/api/common';

axios.defaults.baseURL = 'http://docker.omotenashi.today/api';
axios.defaults.headers.common['Authorization'] = `Bearer ${_ot_ext_token}`;

export default APIController;