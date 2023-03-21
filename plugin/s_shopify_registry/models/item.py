from odoo import models, fields, api
import csv
import os
import json
class s_shopify_registry_country(models.Model):
    _name = 's_shopify_registry.country'
    _description = 's_shopify_registry.country'

    name = fields.Char()
    code = fields.Char()
    def init_country(self, *kw):
        file_path = os.path.abspath(os.path.dirname(os.path.dirname(__file__))) + '/data/country_csv.csv'
        with open(file_path) as csv_file:
            csv_reader = csv.reader(csv_file, delimiter=',')
            line_count = 0
            list = []
            i = 0
            for row in csv_reader:
                i = i + 1

                if i > 0:
                    name = row[0]
                    code = row[1]
                    list.append({'name': name,'code':code})
            self.env['s_shopify_registry.country'].create(list)
    def get_country(self,*kw):
        output = []
        collection= self.search([('id','>',0)])
        for item in collection:
            output.append({
                'id' : item.code,
                'value' : item.code,
                'text': item.name
            })
        return output
    def get_country_json(self):
        outputArr= self.get_country()
        outputDic = {'country_json' : outputArr}
        out = json.dumps(outputDic)
        return  out

class s_shopify_registry_city(models.Model):
    _name = 's_shopify_registry.city'
    _description = 's_shopify_registry.country'

    name = fields.Char()
    code = fields.Char()
