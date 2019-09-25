
@include('scripts.server.configuration.partials.timezone')

@include('scripts.server.configuration.partials.swap')

# ================================================
# Setup Unattended Security Upgrades
# ================================================
cat > /etc/apt/apt.conf.d/50unattended-upgrades << EOF
Unattended-Upgrade::Allowed-Origins {
"Ubuntu zesty-security";
};

Unattended-Upgrade::Package-Blacklist {
//
};
EOF

cat > /etc/apt/apt.conf.d/10periodic << EOF
APT::Periodic::Update-Package-Lists "1";
APT::Periodic::Download-Upgradeable-Packages "1";
APT::Periodic::AutocleanInterval "7";
APT::Periodic::Unattended-Upgrade "1";
EOF

{!! callback_event($server->id, 'updates.configured', 60) !!}