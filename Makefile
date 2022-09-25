exec = local/bin/grab-check  local/bin/host-grab-check

install: install-grab

install-grab: $(exec)
	install -D -t ~/local/bin $^
