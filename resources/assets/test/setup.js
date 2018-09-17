require('jsdom-global')()
global.chai = require('chai')
global.expect = global.chai.expect
global.should = global.chai.should
global.sinon = require('sinon')
