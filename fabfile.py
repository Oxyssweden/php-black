from __future__ import with_statement

import os.path

from fabric.api import *
from fabric.contrib.project import *

"""
Environments
"""
def dev():
        env.hosts = ['192.168.3.101']
        env.user = 'pi'
        env.path = '/var/www'
dev()

"""
Tasks - Deployment
"""

def deploy():
  rsync_project(
	  remote_dir="/var/www/",
	  local_dir="./",
	  exclude=('log/*', 'cache/*', '.htaccess', '.git', '.git*', '.DS_Store', 'fabfile.py*', 'sites/default/files', 'sites/default/files/*', 'sites/default/settings.php', '.sass-cache', '.idea', 'help/video/*', 'apc.php',),
	  )