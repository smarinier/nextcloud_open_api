app_name=open_api
project_dir=$(CURDIR)/../$(app_name)
build_dir=$(project_dir)/build
appstore_dir=$(build_dir)/appstore
package_name=$(app_name)
cert_dir=$(HOME)/.nextcloud/certificates

jssources=$(wildcard js/*) $(wildcard js/*/*) $(wildcard css/*/*)  $(wildcard css/*)
othersources=$(wildcard appinfo/*) $(wildcard css/*/*) $(wildcard controller/*/*) $(wildcard templates/*/*) $(wildcard log/*/*)

all: build

clean:
	rm -rf $(build_dir)
	rm -rf node_modules
	rm -rf js
	rm -rf css
	rm -rf vendor

node_modules: package.json
	npm install --deps

build: node_modules $(jssources)
	npm run build

dev: node_modules $(jssources)
	npm run dev

install-composer-deps-dev:
	composer install -o

docs: node_modules install-composer-deps-dev
	npm run docs

appstore: clean build package

package: build/appstore/$(package_name).tar.gz

build/appstore/$(package_name).tar.gz: build $(othersources)
	mkdir -p $(appstore_dir)
	tar --exclude-vcs \
	--exclude=$(appstore_dir) \
	--exclude=$(project_dir)/node_modules \
	--exclude=$(project_dir)/vendor \
	--exclude=$(project_dir)/build \
	--exclude=$(project_dir)/src \
	--exclude=$(project_dir)/vite.* \
	--exclude=$(project_dir)/.gitattributes \
	--exclude=$(project_dir)/.gitignore \
	--exclude=$(project_dir)/.php* \
	--exclude=$(project_dir)/stylelint.config.cjs \
	--exclude=$(project_dir)/package*.json \
	--exclude=$(project_dir)/composer.* \
	--exclude=$(project_dir)/screenshots \
	--exclude=$(project_dir)/Makefile \
	-cvzf $(appstore_dir)/$(package_name).tar.gz $(project_dir)
	openssl dgst -sha512 -sign $(cert_dir)/$(app_name).key $(appstore_dir)/$(app_name).tar.gz | openssl base64

